Feature: User registration
  As a software developer
  I want to be able login online
  So that I can log in and be able to use the features of the API

  Scenario Outline: Successful login.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be allowed access

    Examples:
      | email               | password                 | password_confirmation    |
      | erickson@reyes.com  | SecuredPassword          | SecuredPassword          |
      | developer@reyes.com | SecuredDeveloperPassword | SecuredDeveloperPassword |


  Scenario Outline: Incorrect password is rejected.
    Given my e-mail is "<email>"
    Given my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be denied access because of incorrect password

    Examples:
      | email               | password          |
      | erickson@reyes.com  | IncorrectPassword |
      | developer@reyes.com | WeirdPassword     |


  Scenario Outline: Anonymous user is rejected.
    Given my e-mail is "<email>"
    Given my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be denied access because I am not a registered user

    Examples:
      | email              | password          |
      | unknown@user.com   | IncorrectPassword |
      | anonymous@user.com | WeirdPassword     |


  Scenario Outline: Rejected for multiple failed login attempts
    Given my e-mail is "<email>"
    Given my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be blocked because of multiple failed login attempts

    Examples:
      | email              | password          |
      | unknown@user.com   | IncorrectPassword |
      | anonymous@user.com | WeirdPassword     |