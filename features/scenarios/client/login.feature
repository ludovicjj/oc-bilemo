@api_all
@api_login

Feature: i need to be able to login to api and obtain token
  Background:
    Given I load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] I submit request with bad credential.
    When I send a "POST" request to "/api/login/client" with username "toto" and password "mypassword"
    Then the response status code should be 401
    And the JSON node "code" should be equal to 401
    And the JSON node "message" should be equal to "Mauvais identifiants. Vérifier votre nom d'utilisateur/mot de passe."

  Scenario: [Submit] I submit request with valid credential.
    When I send a "POST" request to "/api/login/client" with username "johndoe" and password "passphrase"
    Then the response status code should be 200
    And the JSON node "token" should exist