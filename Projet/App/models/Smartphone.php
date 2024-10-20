<?php

include_once('../core/Model.php');

class Smartphone extends Model {

    // Récupérer la liste de tous les smartphones, triée par marque
    public function getSmartphone() {
        $query = "SELECT * FROM smartphones ORDER BY brand ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}