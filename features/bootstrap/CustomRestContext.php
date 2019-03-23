<?php

use Behatch\Context\RestContext;
use Behat\Gherkin\Node\PyStringNode;

class CustomRestContext extends RestContext
{
    /**
     * @When I send a :method request to :url with body :
     * @param $method
     * @param $url
     * @param PyStringNode $string
     * @return mixed
     */
    public function iSendARequestToWithBody2($method, $url, PyStringNode $string)
    {
        $request = $this->request->send(
            $method,
            $this->locatePath($url),
            [],
            [],
            $string !== null ? $string->getRaw() : null,
            ['CONTENT_TYPE' => 'application/json']
        );

        return $request->getContent();
    }

    /**
     * @When I send a :method request to :url with username :username and password :password
     * @param $method
     * @param $url
     * @param $username
     * @param $password
     * @return mixed
     */
    public function iSendARequestToWithUsernameAndPassword($method, $url, $username, $password)
    {
        $requestLogin = $this->request->send(
            $method,
            $this->locatePath($url),
            [],
            [],
            json_encode([
                "username" => $username,
                "password" => $password
            ]),
            ['CONTENT_TYPE' => 'application/json']
        );

        return $requestLogin->getContent();
    }

    /**
     * @When After authentication on url :urlLogin with method :methodLogin as username :username and password :password, I send a :method request to :url with body:
     * @param $urlLogin
     * @param $methodLogin
     * @param $username
     * @param $password
     * @param $method
     * @param $url
     * @param PyStringNode $string
     * @return mixed
     */
    public function afterAuthenticationOnUrlWithMethodAsUsernameAndPasswordISendARequestToWithBody($urlLogin, $methodLogin, $username, $password, $method, $url, PyStringNode $string)
    {
        $requestLogin = $this->request->send(
            $methodLogin,
            $this->locatePath($urlLogin),
            [],
            [],
            json_encode([
                "username" => $username,
                "password" => $password
            ]),
            ['CONTENT_TYPE' => 'application/json']
        );

        $responseLogin = json_decode($requestLogin->getContent(), true);
        $request = $this->request->send(
            $method,
            $this->locatePath($url),
            [],
            [],
            $string !== null ? $string->getRaw() : null,
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => sprintf('Bearer %s', $responseLogin['token'])
            ]
        );

        return $request->getContent();
    }
}