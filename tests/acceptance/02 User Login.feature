Feature: User login
  As a software developer
  I want to be able login online
  So that I can log in and be able to use the features of the API

  Scenario Outline: Successful login.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I try to login
    Then I will be allowed access

    Examples:
      | E-mail                | Password        | Password Confirmation |
      | active-user@reyes.com | SecuredPassword | SecuredPassword       |

  Scenario Outline: Email is empty.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I try to login
    Then I will be denied access because my e-mail is empty

    Examples:
      | E-mail | Password        | Password Confirmation |
      |        | SecuredPassword | SecuredPassword       |

  Scenario Outline: Password is empty.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I try to login
    Then I will be denied access because my password is empty

    Examples:
      | E-mail                | Password | Password Confirmation |
      | active-user@reyes.com |          |                       |

  Scenario Outline: Password was incorrect.
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    When I try to login
    Then I will be denied access because of incorrect password

    Examples:
      | E-mail                | Password          | Password Confirmation |
      | active-user@reyes.com | IncorrectPassword | IncorrectPassword     |
      | active-user@reyes.com | WeirdPassword     | WeirdPassword         |


  Scenario Outline: User is not registered.
    Given my e-mail is "<E-mail>"
    Given my password is "<password>"
    And I confirm that my password is "<Password Confirmation>"
    When I try to login
    Then I will be denied access because I am not a registered user

    Examples:
      | E-mail             | password          | Password Confirmation |
      | unknown@user.com   | IncorrectPassword | IncorrectPassword     |
      | anonymous@user.com | WeirdPassword     | WeirdPassword         |


  Scenario Outline: Rejected for multiple failed login attempts
    Given my e-mail is "<E-mail>"
    And my password is "<Password>"
    And I confirm that my password is "<Password Confirmation>"
    But I am only allowed to fail 3 times
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be denied access because of incorrect password
    When I try to login
    Then I will be blocked because of multiple failed login attempts
    When I try to login
    Then I will be blocked because of multiple failed login attempts

    Examples:
      | E-mail                | Password          | Password Confirmation |
      | active-user@reyes.com | IncorrectPassword | IncorrectPassword     |