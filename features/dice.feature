Feature: Roll dice
  As an anonymous user
  I should be able to roll any dice with a number of faces between 2 and 100

  Scenario: Roll 10 dice of 2 faces
    Given I am an anonymous user
    When I roll 10 dice of 2 faces
    Then I expect a return code 200
    And I get a result between 1 and 2
    
  Scenario: Roll 10 dice of 100 faces
    Given I am an anonymous user
    When I roll 10 dice of 2 faces
    Then I expect a return code 200
    And I get a result between 1 and 100

  Scenario: Roll 1 dice a 200 faces
    Given I am an anonymous user
    When I roll 1 dice of 200 faces
    Then I expect a return code 404