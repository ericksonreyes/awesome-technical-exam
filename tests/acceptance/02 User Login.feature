Feature: User login
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
      | email                 | password        | password_confirmation |
      | active-user@reyes.com | SecuredPassword | SecuredPassword       |

  Scenario Outline: Email is empty.
    Given my e-mail is "<email>"
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be denied access because my e-mail is empty

    Examples:
      | email | password        | password_confirmation |
      |       | SecuredPassword | SecuredPassword       |

  Scenario Outline: Password is empty.
    Given my e-mail is "<email>"
    Given my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be denied access because my password is empty

    Examples:
      | email                 | password |
      | active-user@reyes.com |          |

  Scenario Outline: Password was incorrect.
    Given my e-mail is "<email>"
    Given my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    When I try to login
    Then I will be denied access because of incorrect password

    Examples:
      | email                 | password          |
      | active-user@reyes.com | IncorrectPassword |
      | active-user@reyes.com | WeirdPassword     |


  Scenario Outline: User is not registered.
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
    And my password is "<password>"
    And I confirm that my password is "<password_confirmation>"
    But I am only allowed to fail 3 times
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be blocked because of multiple failed login attempts

    Examples:
      | email                 | password          |
      | active-user@reyes.com | IncorrectPassword |