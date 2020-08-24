<?php

class StarWarsPeople
{
    private $fileManager;
    private $curlRequest;
    private $jsonData = [];

    function __construct()
    {
        $this->fileManager = new StarWarsFileManager();
        $this->curlRequest = new StarWarsRequest();
    }

    public function displayPeople(){

        $name = 'peoples.json';
        $peopleToPlanet = new StarWarsPeoplePlanet();

        if ( $this->fileManager->fileExists($name) ){
            //get info from file
            $jsonData = $this->fileManager->getData($name);

            foreach($jsonData as $page){
                foreach($page['results'] as $res){
                     $this->jsonData[] = [
                         'name' => $res['name'],
                         'gender' => $res['gender'],
                         'homeworld' => $peopleToPlanet->getPlanetByUrl($res['homeworld'])
                     ];
                }
            }

        } else {
            //get from request
            $req = 'people';

            $firstRequest = $this->curlRequest->executeRequest($req);

            foreach($firstRequest['results'] as $res){
                $this->jsonData[] = [
                    'name' => $res['name'],
                    'gender' => $res['gender'],
                    'homeworld' => $peopleToPlanet->getPlanetByUrl($res['homeworld'])
                ];
            }

            $requestData = [];

            $requestData[] = $firstRequest;

            $nextPage = $firstRequest['next'];

            while(1){
                if (is_null($nextPage)){
                    break;
                }
                $nextRequest = $this->curlRequest->executeRequest($req, $nextPage);

                foreach($nextRequest['results'] as $res){
                    $this->jsonData[] = [
                        'name' => $res['name'],
                        'gender' => $res['gender'],
                        'homeworld' => $peopleToPlanet->getPlanetByUrl($res['homeworld'])
                    ];
                }

                $requestData[] = $nextRequest;
                $nextPage = $nextRequest['next'];

            }


            $this->fileManager->saveData($requestData, $name);

        }

        return $this->jsonData;
    }




}
