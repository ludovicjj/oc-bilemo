@api_all
@api_show_user

Feature: i need to be able to get one user from client's user catalog
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request without authentication.
    When I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    Then the response status code should be 401
    And the JSON node "code" should be equal to 401
    And the JSON node "message" should be equal to "Le token est manquant."

  Scenario: [Fail] Submit request with bad client's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" with body:
    """
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Vous n'êtes pas autorisé à consulter les informations de cet utilisateur."

  Scenario: [Fail] Submit request with bad user's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And client have the following user:
      | firstName | lastName | phoneNumber | email         | client  |
      | toto      | dupont   | 0123456789  | toto@gmail.com| johndoe |
    And user with email "toto@gmail.com" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab" with body:
    """
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "Aucun utilisateur ne correspond à l'id : aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab"

  Scenario: [Success] Submit request with valid client's id and user's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And client have the following user:
      | firstName | lastName | phoneNumber | email         | client  |
      | toto      | dupont   | 0123456789  | toto@gmail.com| johndoe |
    And user with email "toto@gmail.com" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" with body:
    """
    """
    Then the response status code should be 200
    And the JSON node "id" should be equal to "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And the JSON node "first_name" should be equal to "toto"
    And the JSON node "last_name" should be equal to "dupont"
    And the JSON node "phone_number" should be equal to "0123456789"
    And the JSON node "email" should be equal to "toto@gmail.com"