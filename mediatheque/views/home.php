<div class="hero">
    <h1>
        <?= $welcome_msg ?>
    </h1>
    <p>Gérez vos emprunts, consultez le catalogue et plus encore.</p>

    <?php if (!isset($_SESSION['user'])): ?>
        <p>
            <a href="<?= htmlspecialchars($basePath) ?>/login" class="btn">Se connecter</a>
        </p>
    <?php else: ?>
        <p>Bonjour, <strong>
                <?= htmlspecialchars($_SESSION['user']['prenom']) ?>
            </strong> !</p>
        <div class="actions">
            <a href="<?= htmlspecialchars($basePath) ?>/documents" class="btn">Voir le catalogue</a>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="<?= htmlspecialchars($basePath) ?>/members" class="btn">Gérer les adhérents</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .hero {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .hero h1 {
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.125rem;
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .actions {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .actions .btn {
        min-width: 200px;
    }
</style>