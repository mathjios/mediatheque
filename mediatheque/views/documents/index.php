<h2>Catalogue</h2>

<div class="search-bar">
    <form action="<?= htmlspecialchars($basePath) ?>/documents" method="GET" style="display: flex; gap: 10px; margin-bottom: 2rem;">
        <input type="text" name="q" placeholder="Rechercher par titre ou auteur..."
            value="<?= htmlspecialchars($query ?? '') ?>">
        <button type="submit" class="btn">Rechercher</button>
        <?php if ($query): ?>
            <a href="<?= htmlspecialchars($basePath) ?>/documents" class="btn btn-danger">Annuler</a>
        <?php endif; ?>
    </form>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="<?= htmlspecialchars($basePath) ?>/documents/add" class="btn" style="margin-bottom: 1rem;">+ Nouveau Document</a>
    <?php endif; ?>
</div>

<div class="document-grid">
    <?php if (empty($documents)): ?>
        <p>Aucun document trouvé.</p>
    <?php else: ?>
        <?php foreach ($documents as $doc): ?>
            <div class="card">
                <div class="card-body">
                    <span class="badge badge-<?= strtolower($doc['type']) ?>">
                        <?= htmlspecialchars($doc['type']) ?>
                    </span>
                    <h3>
                        <?= htmlspecialchars($doc['titre']) ?>
                    </h3>
                    <p class="author">par
                        <?= htmlspecialchars($doc['auteur']) ?>
                    </p>

                    <div class="status">
                        <?php if ($doc['disponible']): ?>
                            <span class="badge badge-success">Disponible</span>
                        <?php else: ?>
                            <span class="badge badge-error">Indisponible</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <a href="<?= htmlspecialchars($basePath) ?>/documents/delete?id=<?= $doc['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Supprimer ?')">Supprimer</a>
                        <?php elseif ($doc['disponible']): ?>
                            <!-- Un membre ne peut pas emprunter seul en général, c'est le biblio qui le fait, mais on peut imaginer un bouton "Reserver" ou juste info -->
                            <small>Disponible au guichet</small>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
