<?php

include_once('../core/Model.php');

class Cart extends Model {

    // Récupérer tous les paniers d'un utilisateur
    public function getCartsByUserId($userId) {
        $query = "SELECT * FROM carts WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un panier spécifique par son ID
    public function getCartById($cartId) {
        $query = "SELECT * FROM carts WHERE id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau panier pour un utilisateur
    public function createCart($userId) {
        $query = "INSERT INTO carts (user_id) VALUES (:user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Supprimer un panier par son ID
    public function deleteCart($cartId) {
        $query = "DELETE FROM carts WHERE id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer le panier d'un utilisateur par son ID utilisateur
    public function getCartByUserId($userId) {
        $query = "SELECT * FROM carts WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un smartphone au panier de l'utilisateur, ou mettre à jour la quantité si déjà présent
    public function addSmartphoneToCart($userId, $smartphoneId, $quantity) {
        // Vérifier si le panier existe déjà pour cet utilisateur
        $query = "SELECT id FROM carts WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($cart) {
            // Vérifier si l'article est déjà dans le panier
            $query = "SELECT id, quantity FROM cart_items WHERE cart_id = :cart_id AND smartphone_id = :smartphone_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cart_id', $cart['id']);
            $stmt->bindParam(':smartphone_id', $smartphoneId);
            $stmt->execute();
            $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($cartItem) {
                // Si l'article existe déjà, mettre à jour la quantité
                $newQuantity = $cartItem['quantity'] + $quantity;
                $query = "UPDATE cart_items SET quantity = :quantity WHERE id = :item_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':quantity', $newQuantity);
                $stmt->bindParam(':item_id', $cartItem['id']);
                return $stmt->execute();
            } else {
                // Si l'article n'existe pas, l'ajouter au panier
                $query = "INSERT INTO cart_items (cart_id, smartphone_id, quantity) VALUES (:cart_id, :smartphone_id, :quantity)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cart_id', $cart['id']);
                $stmt->bindParam(':smartphone_id', $smartphoneId);
                $stmt->bindParam(':quantity', $quantity);
                return $stmt->execute();
            }
        } else {
            // Si aucun panier n'existe, créer un nouveau panier
            if ($this->createCart($userId)) {
                // Récupérer l'ID du nouveau panier
                $cartId = $this->db->lastInsertId();
    
                // Ajouter l'article au nouveau panier
                $query = "INSERT INTO cart_items (cart_id, smartphone_id, quantity) VALUES (:cart_id, :smartphone_id, :quantity)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cart_id', $cartId);
                $stmt->bindParam(':smartphone_id', $smartphoneId);
                $stmt->bindParam(':quantity', $quantity);
                return $stmt->execute();
            } else {
                $message = "Erreur lors de la crétion du panier";
                echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.href = 'index.php?page=connexion';
                </script>";
                return false;
            }
        }
    }
}