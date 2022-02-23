<?php

namespace Acceptance;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context
{
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


    /**
     * @Given my e-mail is :arg1
     */
    public function myEMailIs(string $email)
    {
        throw new PendingException();
    }

    /**
     * @Given my password is :arg1
     */
    public function myPasswordIs(string $password)
    {
        throw new PendingException();
    }

    /**
     * @Given I confirm that my password is :arg1
     */
    public function iConfirmThatMyPasswordIs(string $passwordConfirmation)
    {
        throw new PendingException();
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
     * @Given the minimum length of the password is :arg1
     */
    public function theMinimumLengthOfThePasswordIs(int $passwordMinimumLength)
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
