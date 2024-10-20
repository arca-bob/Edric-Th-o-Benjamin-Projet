<?php

include_once(__DIR__ . '/../models/Cart.php');
include_once(__DIR__ . '/../models/CartItem.php');

class CartController {
    private $cartModel;
    private $cartItemModel;

    public function __construct() {
        $this->cartModel = new Cart;     
        $this->cartItemModel = new CartItem; 
    }

    // Afficher tous les paniers d'un utilisateur
    public function showCarts($userId) {
        $carts = $this->cartModel->getCartsByUserId($userId);
        foreach ($carts as &$cart) {
            $cart['items'] = $this->cartItemModel->getItemsByCartId($cart['id']);
        }
        include(__DIR__ . '/../views/cart.php');
    }

    // Vérifie si un panier existe pour l'utilisateur, sinon en crée un nouveau
    public function ensureCartExists($userId) {
        $cart = $this->cartModel->getCartByUserId($userId);
        if (!$cart) {
            $this->cartModel->createCart($userId);
        }
    }

    // Méthode pour ajouter un produit au panier de l'utilisateur connecté
    public function addItem($userId, $smartphoneId, $quantity) {
        $cart = $this->cartModel->getCartByUserId($userId);
        if ($cart) {
            $cartId = $cart['id'];
            if ($this->cartItemModel->addItem($cartId, $smartphoneId, $quantity)) {
                header('Location: index.php?page=cart&cart_id=' . $cartId);
                exit;
            } else {
                $message = "Erreur lors de l'ajout au panier.";
                echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.href = 'index.php?page=connexion';
                </script>";
            }
        } else {
            $message = "Erreur : Aucun panier trouvé pour cet utilisateur.";
            echo "<script type='text/javascript'>
                alert('$message');
                window.location.href = 'index.php?page=connexion';
            </script>";
        }
    }

    // Mettre à jour la quantité d'un article
    public function updateItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itemId = $_POST['item_id'];
            $quantity = $_POST['quantity'];

            if ($quantity <= 0) {
                $this->cartItemModel->deleteItem($itemId);
            } else {
                $this->cartItemModel->updateItem($itemId, $quantity);
            }

            header('Location: index.php?page=panier');
            exit;
        }
    }

    // Supprimer un article du panier
    public function deleteItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itemId = $_POST['item_id'];
            $this->cartItemModel->deleteItem($itemId);
            header('Location: index.php?page=panier');
            exit;
        }
    }
}
