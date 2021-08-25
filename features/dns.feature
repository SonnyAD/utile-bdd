Feature: Resolve domain name
  As an anonymous user
  I should be able to resolve any domain name

  Scenario: Resolve utile.space domain
    Given I am an anonymous user
    When I resolve the domain "utile.space"
    Then I expect a return code 200
    And I get a list of at least 1 IP

Scenario: Resolve google.com domain
    Given I am an anonymous user
    When I resolve the domain "google.com"
    Then I expect a return code 200
    And I get a list of at least 2 IP

  Scenario: Resolve a wrong domain
    Given I am an anonymous user
    When I resolve the domain "utile.spacefff"
    Then I expect a return code 404