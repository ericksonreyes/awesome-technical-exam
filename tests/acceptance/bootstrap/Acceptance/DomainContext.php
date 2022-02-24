<?php

namespace Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context
{

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
     * @var int
     */
    private $minimumPasswordLength;


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
        $this->email = '';
        $this->password = '';
        $this->passwordConfirmation = '';
        $this->minimumPasswordLength = 0;
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
        $this->minimumPasswordLength = $passwordMinimumLength;
    }

    /**
     * @When I submit my registration information
     */
    public function iSubmitMyRegistrationInformation()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be accepted
     */
    public function myRegistrationWillBeAccepted()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be rejected because the e-mail was left blank
     */
    public function myRegistrationWillBeRejectedBecauseTheEMailWasLeftBlank()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be rejected because the passwords were left blank
     */
    public function myRegistrationWillBeRejectedBecauseThePasswordsWereLeftBlank()
    {
        throw new PendingException();
    }

    /**
     * @When I try to register using the same e-mail again
     */
    public function iTryToRegisterUsingTheSameEMailAgain()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be rejected because the e-mail is already used
     */
    public function myRegistrationWillBeRejectedBecauseTheEMailIsAlreadyUsed()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be rejected because the e-mail is invalid
     */
    public function myRegistrationWillBeRejectedBecauseTheEMailIsInvalid()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be rejected
     */
    public function myRegistrationWillBeRejected()
    {
        throw new PendingException();
    }

    /**
     * @Then I will be informed that the password is provided is too short
     */
    public function iWillBeInformedThatThePasswordIsProvidedIsTooShort()
    {
        throw new PendingException();
    }

    /**
     * @Then my registration will be rejected because the password does not match
     */
    public function myRegistrationWillBeRejectedBecauseThePasswordDoesNotMatch()
    {
        throw new PendingException();
    }
}
