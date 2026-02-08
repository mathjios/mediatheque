<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiathèque</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath) ?>/assets/css/style.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo-icon">
                    <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732L11.268 11.196C11.739 10.725 12.261 10.725 12.732 11.196L19.268 17.732C19.737 18.201 20 18.837 20 19.5C20 20.881 18.881 22 17.5 22H6.5C5.119 22 4 20.881 4 19.5Z" fill="url(#logoGradient)"/>
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="url(#logoGradient2)"/>
                    <defs>
                        <linearGradient id="logoGradient" x1="4" y1="11" x2="20" y2="22" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#6366f1"/>
                            <stop offset="100%" stop-color="#8b5cf6"/>
                        </linearGradient>
                        <linearGradient id="logoGradient2" x1="2" y1="2" x2="22" y2="12" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#8b5cf6"/>
                            <stop offset="100%" stop-color="#6366f1"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span>Médiathèque</span>
            </div>
            <ul>
                <li><a href="<?= htmlspecialchars($basePath) ?>/">Accueil</a></li>
                <li><a href="<?= htmlspecialchars($basePath) ?>/documents">Catalogue</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <li><a href="<?= htmlspecialchars($basePath) ?>/members">Adhérents</a></li>
                        <li><a href="<?= htmlspecialchars($basePath) ?>/loans">Emprunts</a></li>
                    <?php else: ?>
                        <li><a href="<?= htmlspecialchars($basePath) ?>/my-loans">Mes Emprunts</a></li>
                    <?php endif; ?>
                    <li><a href="<?= htmlspecialchars($basePath) ?>/logout" class="btn-logout">Déconnexion (
                            <?= htmlspecialchars($_SESSION['user']['nom']) ?>)
                        </a></li>
                <?php else: ?>
                    <li><a href="<?= htmlspecialchars($basePath) ?>/login">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container">
        <?= $content ?>
    </main>

    <footer>
        <p>&copy;
            <?= date('Y') ?> - BTS SIO SLAM Médiathèque
        </p>
    </footer>
</body>

</html>