<h2>Gestion des Adhérents</h2>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
<div class="actions" style="margin-bottom: 2rem;">
    <a href="<?= htmlspecialchars($basePath) ?>/members/add" class="btn">+ Nouvel Adhérent</a>
</div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Inscrit le</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($members)): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    Aucun adhérent enregistré
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($members as $member): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($member['nom']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($member['prenom']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($member['email']) ?>
                </td>
                <td>
                    <?php
                    $roles = ['admin' => 'Administrateur', 'employee' => 'Bibliothécaire', 'member' => 'Adhérent'];
                    echo $roles[$member['role']] ?? $member['role'];
                    ?>
                </td>
                <td>
                    <?= date('d/m/Y', strtotime($member['created_at'])) ?>
                </td>
                <td>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <a href="<?= htmlspecialchars($basePath) ?>/members/edit?id=<?= $member['id'] ?>" class="btn btn-small">Editer</a>
                        <?php if ($member['id'] != $_SESSION['user']['id']): ?>
                            <a href="<?= htmlspecialchars($basePath) ?>/members/delete?id=<?= $member['id'] ?>" 
                               class="btn btn-small btn-danger" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span style="color: grey;">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>