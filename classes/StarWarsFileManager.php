<?php


class StarWarsFileManager
{
    public function fileExists($name){

        return file_exists("json/".$name);

    }

    public function getData($name){

        $string = file_get_contents("json/".$name);
        if ($string === false) {
            // deal with error...
        }

        $json_a = json_decode($string, true);
        if ($json_a === null) {
            // deal with error...
        }

        return $json_a;
    }

    public function saveData($data, $name){

        $file = fopen('json/'.$name,'w');
        try{
            fwrite($file, json_encode($data));
        } catch(\Exception $e){
            die('cannot save to json file, please check permisions: '.$e->getMessage());
        }


    }
}
