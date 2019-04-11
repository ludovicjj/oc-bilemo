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

  Scenario: [Fail] Submit request with authentication and fixtures and ask page doesn't exist
    And I load fixtures with the following command "doctrine:fixtures:load"
    And I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/phones?page=5" with body:
    """
    {
    }
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "La page 5 n'existe pas"

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
    And the JSON node "total_items" should be equal to 5
    And the JSON node "current_page" should be equal to 1
    And the JSON node "links" should exist
    And the JSON node "phone" should exist
    And the client with username "johndoe" should exist in database