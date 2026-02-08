<h2>
    <?= $action ?> un Adhérent
</h2>

<form action="<?= isset($member) ? htmlspecialchars($basePath) . '/members/edit?id=' . $member['id'] : '' ?>" method="POST" class="form-card">
    <?php if (isset($member)): ?>
        <input type="hidden" name="id" value="<?= $member['id'] ?>">
    <?php endif; ?>
    
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?= isset($member) ? htmlspecialchars($member['nom']) : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="<?= isset($member) ? htmlspecialchars($member['prenom']) : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= isset($member) ? htmlspecialchars($member['email']) : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" <?= !isset($member) ? 'required' : '' ?>>
        <?php if (isset($member)): ?>
            <small style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem; display: block;">Laisser vide pour ne pas modifier le mot de passe</small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="role">Rôle</label>
        <select id="role" name="role">
            <option value="member" <?= (isset($member) && $member['role'] === 'member') ? 'selected' : '' ?>>Adhérent</option>
            <option value="employee" <?= (isset($member) && $member['role'] === 'employee') ? 'selected' : '' ?>>Bibliothécaire</option>
            <option value="admin" <?= (isset($member) && $member['role'] === 'admin') ? 'selected' : '' ?>>Administrateur</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">Enregistrer</button>
        <a href="<?= htmlspecialchars($basePath) ?>/members" class="btn btn-danger">Annuler</a>
    </div>
</form>