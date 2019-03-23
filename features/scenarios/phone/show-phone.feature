@api_all
@api_show_phone

Feature: I need to be able to get phone's details
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |
    And I load this phone with maker :
      | name  | description     | price   | stock | maker |
      | X5    | desciption test | 321.15  | 452   | sony  |

  Scenario: [Fail] Submit request without authentication
    When I send a "GET" request to "/api/phones/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    Then the response status code should be 401
    And the JSON node "code" should be equal to 401
    And the JSON node "message" should be equal to "Le token est manquant."

  Scenario: [Fail] Submit request with invalid phone's id
    And phone with name "X5" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/phones/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab" with body:
    """
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "Aucun téléphone ne correspond à l'id : aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab"

  Scenario: [Success] Submit request with authentication and valid phone id
    And phone with name "X5" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/phones/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" with body:
    """
    {
    }
    """
    Then the response status code should be 200
    And the JSON node "id" should be equal to "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And the JSON node "name" should be equal to "X5"
    And the JSON node "description" should be equal to "desciption test"
    And the JSON node "price" should be equal to 321.15
    And the JSON node "stock" should be equal to 452
    And the phone with id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" should exist in database
    And the maker with name "sony" should exist in database