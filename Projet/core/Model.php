<?php

include_once('../config/config.php');

class Model {
    protected $db;

    function __construct() {
        $this->db = Config::connexion();
    }
}
