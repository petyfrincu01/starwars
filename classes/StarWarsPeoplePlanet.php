<?php

class StarWarsPeoplePlanet
{
    private $fileManager;
    private $curlRequest;
    private $jsonData = [];

    function __construct()
    {
        $this->fileManager = new StarWarsFileManager();
        $this->curlRequest = new StarWarsRequest();
    }

    public function getPlanetByUrl($planetUrl){

        $planet = explode('/', $planetUrl);
        $planetFile = $planet[4].$planet[5].'.json';

        if ( $this->fileManager->fileExists($planetFile) ){

            $jsonData = $this->fileManager->getData($planetFile);

        } else {

            $jsonData = $this->curlRequest->executeRequest(null, $planetUrl);
            $this->fileManager->saveData($jsonData, $planetFile);

        }

        return $jsonData['name'];
    }

}
