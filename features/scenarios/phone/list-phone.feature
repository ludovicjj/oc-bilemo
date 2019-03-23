@api_all
@api_list_phone

Feature: I need to be able to get all phones
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request without authentication.
    When I send a "GET" request to "/api/phones"
    Then the response status code should be 401
    And the JSON node "code" should be equal to 401
    And the JSON node "message" should be equal to "Le token est manquant."

  Scenario: [Fail] Submit request with authentication and without fixtures
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/phones" with body:
    """
    """
    Then the response status code should be 204
    And the response should be empty
    And the client with username "johndoe" should exist in database

  Scenario: [Success] Submit request with authentication and fixtures
    And I load fixtures with the following command "doctrine:fixtures:load"
    And I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/phones" with body:
    """
    {
    }
    """
    Then the response status code should be 200
    And the JSON node "root" should have 5 elements
    And the client with username "johndoe" should exist in database