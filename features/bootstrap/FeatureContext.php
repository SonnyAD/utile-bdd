<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    protected $client = null;
    protected $responses = array();

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        
    }

    /**
     * @Given I am an anonymous user
     */
    public function iAmAnAnonymousUser()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'https://utile.space', 'http_errors' => false]);
    }

    /**
     * @When I roll :arg1 dice of :arg2 faces
     */
    public function iRollDiceOfFaces($arg1, $arg2)
    {
        for ($i = 0; $i < $arg1; $i++)
        {
            $this->responses[] = $this->client->get('/api/d'.$arg2);
        }
    }

    /**
     * @Then I expect a return code :arg1
     */
    public function iExpectAReturnCode($arg1)
    {
        foreach ($this->responses as $response)
        {
            $response_code = $response->getStatusCode();
            if ($response_code <> $arg1)
                throw new Exception("I was expecting a $arg1 return code, but got a $response_code");
        }
    }

    /**
     * @Then I get a result between :arg1 and :arg2
     */
    public function iGetAResultBetweenAnd($arg1, $arg2)
    {
        foreach ($this->responses as $response)
        {
            $dice = intval($response->getBody()->getContents());
            if (!($arg1 <= $dice && $dice <= $arg2))
                throw new Exception("I was expecting a result between $arg1 and $arg2, but got a $dice");
        }
    }

    /**
     * @When I resolve the domain :arg1
     */
    public function iResolveTheDomain($arg1)
    {
        $this->responses[0] = $this->client->get('/api/dns/'.$arg1, [
            'headers'        => ['Accept' => 'application/json'],
        ]);
    }

    /**
     * @Then I get a list of IP
     */
    public function iGetAListOfIp()
    {
    }

    /**
     * @Then I get a list of at least :arg1 IP
     */
    public function iGetAListOfAtLeastIp($arg1)
    {
        $data = json_decode($this->responses[0]->getBody(), true);
        $count = count($data["addresses"]);
        if ($count < $arg1)
            throw new Exception("I was expecting at least $arg1 IP for the domain, but got $count");
    }
}
