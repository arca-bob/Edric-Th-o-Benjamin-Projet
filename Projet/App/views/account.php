<?php
// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=connexion');
    exit;
}
?>
<main class="home account">
    <h1>Mon Compte</h1>
    <form action="index.php?page=update_account" method="POST">
        <div class="formGroup">
            <label for="first_name">Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : '' ?>" required>
        </div>
        <div class="formGroup">
            <label for="last_name">Nom :</label>
            <input type="text" id="last_name" name="last_name" value="<?= isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : '' ?>" required>
        </div>
        <div class="formGroup">
            <label for="email">E-mail :</label>
            <input type="email" id="email" name="email" value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>" required>
        </div>
        <div class="formGroup">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
            <small>Laissez vide si vous ne souhaitez pas changer le mot de passe</small>
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
    <form action="index.php?page=logout" method="POST">
        <button type="submit">Se déconnecter</button>
    </form>
    <form action="index.php?page=delete_account" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte? Cette action est irréversible.');">
        <button type="submit">Supprimer le compte</button>
    </form>
</main>
