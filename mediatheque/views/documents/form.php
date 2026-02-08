<h2>
    <?= $action ?> un Document
</h2>

<form action="" method="POST" class="form-card">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" required>
    </div>

    <div class="form-group">
        <label for="auteur">Auteur / Réalisateur</label>
        <input type="text" id="auteur" name="auteur" required>
    </div>

    <div class="form-group">
        <label for="type">Type de document</label>
        <select id="type" name="type" required>
            <option value="Livre">Livre</option>
            <option value="CD">CD</option>
            <option value="DVD">DVD</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">Enregistrer</button>
        <a href="<?= htmlspecialchars($basePath) ?>/documents" class="btn btn-danger">Annuler</a>
    </div>
</form>