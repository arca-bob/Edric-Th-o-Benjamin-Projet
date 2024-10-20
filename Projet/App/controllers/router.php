<?php

session_start();

$page = (isset($_GET['page'])) ? $_GET['page'] : 'home';

switch ($page) {
    case 'smartphone':
        include_once('SmartphoneController.php');
        $home = new SmartphoneController;
        $home->home();
        break;

    case 'inscription':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->showRegistrationForm(); // Affiche le formulaire d'inscription
        break;

    case 'register':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->register(); // Traite l'inscription
        break;

    case 'connexion':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->showLoginForm(); // Affiche le formulaire de connexion
        break;

    case 'login':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->login(); // Traite la connexion
        break;

    case 'account':
        include_once(__DIR__ . '/../views/account.php');
        break;
    
    case 'update_account':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->updateAccount(); // Met à jour le compte
        break;

    case 'delete_account':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->deleteAccount(); // Supprime le compte
        break;

    case 'panier':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        include_once('CartController.php');
        $cartController = new CartController;
        $userId = $_SESSION['user_id'];
        $cartController->showCarts($userId); // Affiche le panier de l'utilisateur
        break;

    case 'add_to_cart':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        include_once('CartController.php');
        $cartController = new CartController;
        $userId = $_SESSION['user_id'];
        $smartphoneId = $_POST['smartphone_id'];
        $quantity = $_POST['quantity'];
        $cartController->addItem($userId, $smartphoneId, $quantity); // Traite l'ajout d'un article au panier
        break; 

    case 'update_item':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        include_once('CartController.php');
        $cartController = new CartController;
        $cartController->updateItem(); // Traite la mise à jour d'un article dans le panier
        break;

    case 'delete_item':
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }
        include_once('CartController.php');
        $cartController = new CartController;
        $cartController->deleteItem(); // Traite la suppression d'un article du panier
        break;

    case 'logout':
        include_once('UserController.php');
        $userController = new UserController;
        $userController->logout(); // Traite la déconnexion
        break;
        
    case 'home':
    default:
        include_once('SmartphoneController.php');
        $home = new SmartphoneController;
        $home->home();
        break;
}
