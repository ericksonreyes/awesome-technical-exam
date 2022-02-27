Feature: User registration
  As a software developer
  I want to be able register online
  So I will be a registered user and be able to use the features of the API


  Scenario Outline: Successful registration.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I submit my registration information
    Then my registration will be accepted

    Examples:
      | E-mail              | Password                 | Password Confirmation    |
      | erickson@reyes.com  | SecuredPassword          | SecuredPassword          |
      | developer@reyes.com | SecuredDeveloperPassword | SecuredDeveloperPassword |


  Scenario Outline: E-mail was left blank.
    Given my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I submit my registration information
    Then my registration will be rejected because the e-mail was left blank

    Examples:
      | Password        | Password Confirmation |
      | SecuredPassword | SecuredPassword       |


  Scenario Outline: Passwords were left blank.
    Given my e-mail is "<E-mail>"
    When I submit my registration information
    Then my registration will be rejected because the passwords were left blank

    Examples:
      | E-mail             |
      | erickson@reyes.com |


  Scenario Outline: E-mail is already used.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I submit my registration information
    Then my registration will be accepted
    When I try to register using the same e-mail again
    Then my registration will be rejected because the e-mail is already used

    Examples:
      | E-mail             | Password        | Password Confirmation |
      | erickson@reyes.com | SecuredPassword | SecuredPassword       |


  Scenario Outline: E-mail is not valid.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I submit my registration information
    Then my registration will be rejected because the e-mail is invalid

    Examples:
      | E-mail            | Password        | Password Confirmation |
      | ericksonreyes.com | SecuredPassword | SecuredPassword       |
      | erickson@reyes    | SecuredPassword | SecuredPassword       |
      | @reyes.com        | SecuredPassword | SecuredPassword       |


  Scenario Outline: Password is too short.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    And the minimum length of the password is "<Minimum Password Length>"
    When I submit my registration information
    Then my registration will be rejected
    And I will be informed that the password is provided is too short

    Examples:
      | E-mail             | Password        | Password Confirmation | Minimum Password Length |
      | erickson@reyes.com | Secure          | Secure                | 7                       |
      | erickson@reyes.com | SecuredPassword | SecuredPassword       | 16                      |


  Scenario Outline: Passwords doesn't match.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I submit my registration information
    Then my registration will be rejected because the password does not match

    Examples:
      | E-mail             | Password        | Password Confirmation |
      | erickson@reyes.com | SecuredPassword | SecuredPasswords      |
      | erickson@reyes.com | SecuredPassw0rd | SecuredPassword       |
