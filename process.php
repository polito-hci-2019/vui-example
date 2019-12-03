<?php

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

require __DIR__.'vendor/autoload.php';

if(isset($_POST['submit'])) {
    $userquery = $_POST['message'];

    // create a new session
    $credential = array('credentials' => "client-secret.json");
    $sessionClient = new SessionsClient($credential);

    try {
        // replace the project id, since it is "fake"
        $session = $sessionClient->sessionName("weatheragent-ysfsew", 123456 ?: uniqid());

        // prepare a new query input...
        $queryInput = new QueryInput();
        // ... and the inner text
        $textInput = new TextInput();
        $textInput->setText($userquery);
        $textInput->setLanguageCode("en-US");

        $queryInput->setText($textInput);

        // send the request and get the response
        $response = $sessionClient->detectIntent($session, $queryInput);

        $queryResult = $response->getQueryResult();

        // the textual response is in "fullfilment"
        $fulfillmentText = $queryResult->getFulfillmentText();

        // finally, respond to the ajax request
        echo $fulfillmentText;

    } finally {
        $sessionClient->close();
    }
}