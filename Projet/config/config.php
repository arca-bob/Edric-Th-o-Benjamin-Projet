<?php


class Config {
    public static function connexion() {
        try {
            $db = new PDO('pgsql:host=localhost;port=5432;dbname=projet_php','postgres','edric');
            // echo "ok";
            return $db;
        } catch(Exception $e) {
            echo $e;
        }
    }
}

$db = Config::connexion();