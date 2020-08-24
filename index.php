<?php

require_once(__DIR__.'/classes/autoload.php');

$result = (new StarWarsPeople())->displayPeople();

$output = '<h2>StarWars Peoples</h2>';

foreach($result as $res){

    $output .= '<div>'.$res['name'] .' is a '.$res['gender']. ' from '.$res['homeworld'].' planet</div>';

}

echo $output;

