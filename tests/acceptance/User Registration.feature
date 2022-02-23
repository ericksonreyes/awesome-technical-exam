Feature: User registration
  As a software developer
  I want to be able register online
  So that I can log in and be able to use the features of the API


  Scenario Outline: Successful registration.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I submit my registration information
    Then my registration will be accepted

    Examples:
      | email               | password                 | password_confirmation    |
      | erickson@reyes.com  | SecuredPassword          | SecuredPassword          |
      | developer@reyes.com | SecuredDeveloperPassword | SecuredDeveloperPassword |


  Scenario Outline: E-mail was left blank.
    Given my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I submit my registration information
    Then my registration will be rejected because the e-mail was left blank

    Examples:
      | password        | password_confirmation |
      | SecuredPassword | SecuredPassword       |


  Scenario Outline: Passwords were left blank.
    Given my e-mail is "<email>"
    When I submit my registration information
    Then my registration will be rejected because the passwords were left blank

    Examples:
      | email              | password        | password_confirmation |
      | erickson@reyes.com | SecuredPassword | SecuredPassword       |


  Scenario Outline: E-mail is already used.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I submit my registration information
    Then my registration will be accepted
    When I try to register using the same e-mail again
    Then my registration will be rejected because the e-mail is already used

    Examples:
      | email              | password        | password_confirmation |
      | erickson@reyes.com | SecuredPassword | SecuredPassword       |


  Scenario Outline: E-mail is not valid.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I submit my registration information
    Then my registration will be rejected because the e-mail is invalid

    Examples:
      | email             | password        | password_confirmation |
      | ericksonreyes.com | SecuredPassword | SecuredPassword       |
      | erickson@reyes    | SecuredPassword | SecuredPassword       |
      | @reyes.com        | SecuredPassword | SecuredPassword       |


  Scenario Outline: Password is too short.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    And the minimum length of the password is "<minimum_password_length>"
    When I submit my registration information
    Then my registration will be rejected
    And I will be informed that the password is provided is too short

    Examples:
      | email              | password        | password_confirmation | minimum_password_length |
      | erickson@reyes.com | Secure          | Secure                | 7                       |
      | erickson@reyes.com | SecuredPassword | SecuredPassword       | 16                      |


  Scenario Outline: Passwords doesn't match.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I submit my registration information
    Then my registration will be rejected because the password does not match

    Examples:
      | email              | password        | password_confirmation |
      | erickson@reyes.com | SecuredPassword | SecuredPasswords      |
      | erickson@reyes.com | SecuredPassw0rd | SecuredPassword       |
