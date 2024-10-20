<?php
include_once(__DIR__ . '/../models/User.php');
include_once(__DIR__ . '/../models/Cart.php');
include_once(__DIR__ . '/../controllers/CartController.php');

class UserController {
    private $model;

    public function __construct() {
        $this->model = new User;
    }

    // Méthode pour afficher la page d'inscription
    public function showRegistrationForm() {
        include(__DIR__ . '/../views/register.php');
    }

    // Méthode pour gérer l'inscription d'un nouvel utilisateur
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifier si l'email existe déjà
            if ($this->model->emailExists($email)) {
                echo "L'email est déjà utilisé.";
                return;
            }

            // Enregistrer l'utilisateur
            if ($this->model->register($firstName, $lastName, $email, $password)) {
                header('Location: index.php?page=connexion');
                exit;
            } else {
                $message = "Erreur lors de l'inscription";
                echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.href = 'index.php?page=connexion';
                </script>";
            }
        }
    }

    // Méthode pour afficher la page de connexion
    public function showLoginForm() {
        include(__DIR__ . '/../views/login.php');
    }

    // Méthode pour gérer la connexion d'un utilisateur
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Tenter de connecter l'utilisateur
            $user = $this->model->login($email, $password);
            if ($user) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
    
                // S'assurer que l'utilisateur ait un panier
                $cartController = new CartController();
                $cartController->ensureCartExists($user['id']);
                
                header('Location: index.php?page=home');
                exit;
            } else {
                $message = "Identifiants invalides";
                echo "<script type='text/javascript'>
                    alert('$message');
                    window.location.href = 'index.php?page=connexion';
                </script>";
            }
        }
    }    

    // Méthode pour mettre à jour le compte d'un utilisateur
    public function updateAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Mise à jour des informations de l'utilisateur
            $this->model->updateUser($userId, $firstName, $lastName, $email, $password);

            // Mise à jour des informations de la session
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;
            $_SESSION['email'] = $email;

            $message = "Informations mises à jour.";
            echo "<script type='text/javascript'>
                alert('$message');
                window.location.href = 'index.php?page=connexion';
            </script>";
            exit;
        }
    }

    // Méthode pour supprimer le compte d'un utilisateur
    public function deleteAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $this->model->deleteUser($userId); // Supprimer l'utilisateur de la base de données
            session_destroy();
            header('Location: index.php?page=connexion');
            exit;
        }
    }

    // Méthode pour gérer la déconnexion d'un utilisateur
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?page=home');
        exit;
    }
}
