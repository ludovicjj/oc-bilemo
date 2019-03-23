@api_all
@api_add_user

Feature: i need to be able to add user
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request without authentication.
    When I send a "POST" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users"
    Then the response status code should be 401
    And the JSON node "code" should be equal to 401
    And the JSON node "message" should be equal to "Le token est manquant."

  Scenario: [Fail] Submit request with invalid client's id
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "POST" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaab/users" with body:
    """
    {
    }
    """
    Then the response status code should be 403
    And the JSON node "message" should be equal to "Vous n'êtes pas autorisé à ajouter un utilisateur dans ce catalogue."

  Scenario: [Fail] Submit request with invalid payload.
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "POST" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users" with body:
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "firstName": [
        "Veuillez saisir votre prénom."
      ],
      "lastName": [
        "Veuillez saisir votre nom de famille."
      ],
      "phoneNumber": [
        "Veuillez saisir votre numéro de telephone."
      ],
      "email": [
        "Veuillez saisir une adresse email."
      ]
    }
    """

  Scenario: [Fail] Submit request with user's email and user's phone number already exist
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    And client have the following user:
      | firstName | lastName | phoneNumber | email         | client  |
      | toto      | dupont   | 0123456789  | toto@gmail.com| johndoe |
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "POST" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users" with body:
    """
    {
      "firstName": "sponge",
      "lastName": "bob",
      "phoneNumber": "0123456789",
      "email": "toto@gmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "email": [
       "Cette adresse email déjà utilisé."
      ],
      "phoneNumber": [
        "Ce numero de téléphone est déjà utilisé."
      ]
    }
    """

  Scenario: [Success] Submit request with valid payload
    And client with username "johndoe" should have following id "aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa"
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "POST" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users" with body:
    """
    {
      "firstName": "sponge",
      "lastName": "bob",
      "phoneNumber": "0123456789",
      "email": "spongebob@gmail.com"
    }
    """
    Then the response status code should be 201
    And the response should be empty
    And the user with email "spongebob@gmail.com" should exist in database