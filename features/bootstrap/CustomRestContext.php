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
}