<main class="home login">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php header('Location: index.php?page=account'); exit; ?>
    <?php else: ?>
        <h1>Connexion</h1>
        <form action="index.php?page=login" method="POST">
            <div class="formGroup">
                <label for="email">E-mail :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="formGroup">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="index.php?page=inscription">Inscrivez-vous ici</a>.</p>
    <?php endif; ?>
</main>
