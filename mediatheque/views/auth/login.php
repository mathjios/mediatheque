<div class="auth-container">
    <h2>Connexion</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($basePath) ?>/login" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn">Se connecter</button>
        </div>
    </form>

    <p style="margin-top: 1rem;">
        Pas encore de compte ?
        <a href="<?= htmlspecialchars($basePath) ?>/register">Créer un compte</a>
    </p>
</div>
