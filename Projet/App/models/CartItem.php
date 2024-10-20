<?php
include_once('../core/Model.php');

class CartItem extends Model {
    // Récupérer tous les articles d'un panier
    public function getItemsByCartId($cartId) {
        $query = "SELECT cart_items.id, smartphones.name AS smartphone_name, cart_items.quantity, smartphones.price 
                  FROM cart_items 
                  JOIN smartphones ON cart_items.smartphone_id = smartphones.id 
                  WHERE cart_items.cart_id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter ou mettre à jour un article au panier
    public function addItem($cartId, $smartphoneId, $quantity) {
        // Vérifier si l'article est déjà dans le panier
        $query = "SELECT id, quantity FROM cart_items WHERE cart_id = :cart_id AND smartphone_id = :smartphone_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cart_id', $cartId);
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
            // Sinon, ajouter un nouvel article au panier
            $query = "INSERT INTO cart_items (cart_id, smartphone_id, quantity) VALUES (:cart_id, :smartphone_id, :quantity)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cart_id', $cartId);
            $stmt->bindParam(':smartphone_id', $smartphoneId);
            $stmt->bindParam(':quantity', $quantity);
            return $stmt->execute();
        }
    }

    // Mettre à jour la quantité d'un article
    public function updateItem($itemId, $quantity) {
        $query = "UPDATE cart_items SET quantity = :quantity WHERE id = :item_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':item_id', $itemId);
        return $stmt->execute();
    }

    // Supprimer un article du panier
    public function deleteItem($itemId) {
        $query = "DELETE FROM cart_items WHERE id = :item_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':item_id', $itemId);
        return $stmt->execute();
    }
}
