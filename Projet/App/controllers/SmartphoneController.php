<?php

include_once(__DIR__ . '/../models/Smartphone.php');

class SmartphoneController {
    private $model;

    public function __construct() {
        $this->model = new Smartphone;     
    }

    // Affiche la page d'accueil avec la liste des smartphones
    public function home() {
       $smartphones = $this->model->getSmartphone();
       include(__DIR__ . '/../views/home.php');
    }
}