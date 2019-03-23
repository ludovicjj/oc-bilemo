@api_all
@api_delete_user

Feature: I need to be able to delete one user in client's user catalog
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request without authentication.
    When I send a "DELETE" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    Then the response status code should be 401
    And the JSON node "code" should be equal to 401
    And the JSON node "message" should be equal to "Le token est manquant."

  Scenario: [Fail] Submit request with authentication and invalid client's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "DELETE" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" with body:
    """
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Vous n'êtes pas autorisé à supprimer un utilisateur dans ce catalogue."

  Scenario: [Fail] Submit request with authentication, valid client's id and invalid user's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And client have the following user:
      | firstName | lastName | phoneNumber | email         | client  |
      | toto      | dupont   | 0123456789  | toto@gmail.com| johndoe |
    And user with email "toto@gmail.com" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "DELETE" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab" with body:
    """
    """
    Then the response status code should be 404
    And the JSON node "message" should be equal to "Aucun utilisateur ne correspond à l'id : aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab"

  Scenario: [Success] Submit request with authentication, valid client's id and user's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And client have the following user:
      | firstName | lastName | phoneNumber | email         | client  |
      | toto      | dupont   | 0123456789  | toto@gmail.com| johndoe |
    And user with email "toto@gmail.com" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "DELETE" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" with body:
    """
    """
    Then the response status code should be 204
    And the user with email "toto@gmail.com" should not exist in database