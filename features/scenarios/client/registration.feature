@api_all
@api_registration_client

Feature: As an anonymous user, I need to be able to submit registration request
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request with invalid payload.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "username": [
        "Veuillez choisir un pseudo."
      ],
      "password": [
        "Veuillez choisir un mot de passe."
      ],
      "email": [
        "Veuillez saisir une adresse email."
      ]
    }
    """
  Scenario: [Fail] Submit request with already exist username and email in payload.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
      "username": "johndoe",
      "password": "passphrase",
      "email": "johndoe@gmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "username": [
        "Ce pseudo est déjà utilisé."
      ],
      "email": [
        "Cette adresse e-mail est déjà utilisée."
      ]
    }
    """
  Scenario: [Success] Submit request with valid payload.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
      "username": "toto",
      "password": "passphrase",
      "email": "toto@gmail.com"
    }
    """
    Then the response status code should be 201
    And the response should be empty
    And the client with username "toto" should exist in database