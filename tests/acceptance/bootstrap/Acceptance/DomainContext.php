<?php

namespace Acceptance;

use Acceptance\Mock\MockFailedUserAuthenticationLogger;
use Acceptance\Mock\MockAuthenticateUserCommand;
use Acceptance\Mock\MockUserPasswordEncryptionService;
use Acceptance\Mock\MockUserRepository;
use Acceptance\Mock\RegisterUserCommand;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Exception;
use Github\Application\EmailFormatValidatingUserRegistrationHandler;
use Github\Application\FailedAuthenticationAttemptVerifyingUserAuthenticationHandler;
use Github\Application\PasswordLengthValidatingUserRegistrationHandler;
use Github\Application\UserAuthenticationHandler;
use Github\Application\UserPasswordEncryptionServiceInterface;
use Github\Application\UserRegistrationHandler;
use Github\Application\UserRegistrationHandlerInterface;
use Github\Domain\Model\Exception\DuplicateUsernameException;
use Github\Domain\Model\Exception\IncorrectPasswordException;
use Github\Domain\Model\Exception\InvalidEmailException;
use Github\Domain\Model\Exception\MismatchedPasswordsException;
use Github\Domain\Model\Exception\MissingEmailException;
use Github\Domain\Model\Exception\MissingPasswordException;
use Github\Domain\Model\Exception\MissingUsernameException;
use Github\Domain\Model\Exception\PasswordTooShortException;
use Github\Domain\Model\Exception\TooManyFailedAuthenticationAttemptsException;
use Github\Domain\Model\Exception\UserNotFoundException;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $passwordConfirmation;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserRegistrationHandlerInterface
     */
    private $userRegistrationHandler;

    /**
     * @var Exception
     */
    private $encounteredException;

    /**
     * @var UserPasswordEncryptionServiceInterface
     */
    private $userPasswordEncryptionService;

    /**
     * @var UserAuthenticationHandler
     */
    private $userAuthenticationHandler;

    /**
     * @var int
     */
    private $allowedLoginAttempts = 0;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /** @BeforeScenario
     * @param $event
     */
    public function before($event)
    {
        $this->id = md5(mt_rand(1, 1000));
        $this->email = '';
        $this->password = '';
        $this->passwordConfirmation = '';
        $this->encounteredException = null;
        $this->userRegistrationHandler = [];
        $this->userRepository = new MockUserRepository();
        $this->userPasswordEncryptionService = new MockUserPasswordEncryptionService();

        $userRegistrationHandler = new UserRegistrationHandler(
            $this->userRepository,
            $this->userPasswordEncryptionService
        );
        $emailValidatingUserRegistrationHandler = new EmailFormatValidatingUserRegistrationHandler(
            $userRegistrationHandler
        );
        $this->userRegistrationHandler = $emailValidatingUserRegistrationHandler;

        $this->userAuthenticationHandler = new UserAuthenticationHandler(
            $this->userRepository,
            $this->userPasswordEncryptionService
        );
    }

    /**
     * @Given my e-mail is :arg1
     * @param string $email
     */
    public function myEMailIs(string $email)
    {
        $this->email = $email;
    }

    /**
     * @Given my password is :arg1
     * @param string $password
     */
    public function myPasswordIs(string $password)
    {
        $this->password = $password;
    }

    /**
     * @Given I confirm that my password is :arg1
     * @param string $passwordConfirmation
     */
    public function iConfirmThatMyPasswordIs(string $passwordConfirmation)
    {
        $this->passwordConfirmation = $passwordConfirmation;
    }

    /**
     * @Given the minimum length of the password is :arg1
     * @param int $passwordMinimumLength
     */
    public function theMinimumLengthOfThePasswordIs(int $passwordMinimumLength)
    {
        $this->userRegistrationHandler = new PasswordLengthValidatingUserRegistrationHandler(
            $this->userRegistrationHandler,
            $passwordMinimumLength
        );
    }

    /**
     * @Given I am only allowed to fail :arg1 times
     * @param int $allowedLoginAttempts
     */
    public function iAmOnlyAllowedToFailTimes(int $allowedLoginAttempts)
    {
        $this->allowedLoginAttempts = $allowedLoginAttempts;
    }

    /**
     * @When I submit my registration information
     */
    public function iSubmitMyRegistrationInformation()
    {
        try {
            $registerUserCommand = (new RegisterUserCommand())
                ->setId($this->id)
                ->setUsername($this->email)
                ->setPassword($this->password)
                ->setPasswordConfirmation($this->passwordConfirmation);

            $this->userRegistrationHandler->handleThis($registerUserCommand);
        } catch (Exception $exception) {
            $this->encounteredException = $exception;
        }
    }


    /**
     * @When I try to login
     */
    public function iTryToLogin()
    {
        try {
            $authenticateUserCommand = new MockAuthenticateUserCommand($this->email, $this->password);

            if ($this->allowedLoginAttempts > 0) {
                $failedUserAuthenticationLogger = new MockFailedUserAuthenticationLogger($this->allowedLoginAttempts);

                $this->userAuthenticationHandler = new FailedAuthenticationAttemptVerifyingUserAuthenticationHandler(
                    $this->userAuthenticationHandler,
                    $failedUserAuthenticationLogger
                );
            }

            $this->userAuthenticationHandler->handleThis($authenticateUserCommand);
        } catch (Exception $exception) {
            $this->encounteredException = $exception;
        }
    }

    /**
     * @Then my registration will be accepted
     */
    public function myRegistrationWillBeAccepted()
    {
        $newUser = $this->userRepository->findOneByUsername($this->email);
        assert(
            $newUser instanceof UserInterface,
            'User was not registered. When it should have been.'
        );
    }

    /**
     * @Then my registration will be rejected because the e-mail was left blank
     */
    public function myRegistrationWillBeRejectedBecauseTheEMailWasLeftBlank()
    {
        assert(
            $this->encounteredException instanceof MissingEmailException,
            'Empty email was accepted. When it should not be.'
        );
    }

    /**
     * @Then my registration will be rejected because the passwords were left blank
     */
    public function myRegistrationWillBeRejectedBecauseThePasswordsWereLeftBlank()
    {
        assert(
            $this->encounteredException instanceof MissingPasswordException,
            'Empty password was accepted.'
        );
    }

    /**
     * @When I try to register using the same e-mail again
     */
    public function iTryToRegisterUsingTheSameEMailAgain()
    {
        $registerUserCommand = (new RegisterUserCommand())
            ->setId($this->id)
            ->setUsername($this->email)
            ->setPassword($this->password)
            ->setPasswordConfirmation($this->passwordConfirmation);

        try {
            $this->userRegistrationHandler->handleThis($registerUserCommand);
            $this->userRegistrationHandler->handleThis($registerUserCommand);
        } catch (Exception $exception) {
            $this->encounteredException = $exception;
        }
    }

    /**
     * @Then my registration will be rejected because the e-mail is already used
     */
    public function myRegistrationWillBeRejectedBecauseTheEMailIsAlreadyUsed()
    {
        assert(
            $this->encounteredException instanceof DuplicateUsernameException,
            'Duplicate email was accepted. When it should not be.'
        );
    }

    /**
     * @Then my registration will be rejected because the e-mail is invalid
     */
    public function myRegistrationWillBeRejectedBecauseTheEMailIsInvalid()
    {
        assert(
            $this->encounteredException instanceof InvalidEmailException,
            'Invalid e-mail was accepted. When it should not be.'
        );
    }

    /**
     * @Then my registration will be rejected
     */
    public function myRegistrationWillBeRejected()
    {
        assert(
            $this->encounteredException instanceof Exception,
            'Registration was accepted. When it should not be.'
        );
    }

    /**
     * @Then I will be informed that the password is provided is too short
     */
    public function iWillBeInformedThatThePasswordIsProvidedIsTooShort()
    {
        assert(
            $this->encounteredException instanceof PasswordTooShortException,
            'Short password was accepted. When it should not be.'
        );
    }

    /**
     * @Then my registration will be rejected because the password does not match
     */
    public function myRegistrationWillBeRejectedBecauseThePasswordDoesNotMatch()
    {
        assert(
            $this->encounteredException instanceof MismatchedPasswordsException,
            'Mismatched passwords was accepted. When it should not be.'
        );
    }

    /**
     * @Then I will be allowed access
     */
    public function iWillBeAllowedAccess()
    {
        $message = 'An error was raised. When it should not be.';
        if ($this->encounteredException instanceof Exception) {
            $message = get_class($this->encounteredException) . ' error was raised. When it should not be.';
        }

        assert(
            is_null($this->encounteredException),
            $message
        );
    }

    /**
     * @Then I will be denied access because of incorrect password
     */
    public function iWillBeDeniedAccessBecauseOfIncorrectPassword()
    {
        assert(
            $this->encounteredException instanceof IncorrectPasswordException,
            'Empty password was accepted. When it should not be.'
        );
    }

    /**
     * @Then I will be denied access because I am not a registered user
     */
    public function iWillBeDeniedAccessBecauseIAmNotARegisteredUser()
    {
        assert(
            $this->encounteredException instanceof UserNotFoundException,
            'Anonymous user was authenticated. When it should not be.'
        );
    }

    /**
     * @Then I will be blocked because of multiple failed login attempts
     */
    public function iWillBeBlockedBecauseOfMultipleFailedLoginAttempts()
    {
        assert(
            $this->encounteredException instanceof TooManyFailedAuthenticationAttemptsException,
            'Excessive failed authentication attempts was allowed. When it should not be.'
        );
    }

    /**
     * @Then I will be denied access because my e-mail is empty
     */
    public function iWillBeDeniedAccessBecauseMyEMailIsEmpty()
    {
        assert(
            $this->encounteredException instanceof MissingUsernameException,
            'Empty e-mail was accepted. When it should not be.'
        );
    }

    /**
     * @Then I will be denied access because my password is empty
     */
    public function iWillBeDeniedAccessBecauseMyPasswordIsEmpty()
    {
        assert(
            $this->encounteredException instanceof MissingPasswordException,
            'Empty password was accepted. When it should not be.'
        );
    }
}
