<h2>Gestion des Emprunts</h2>

<div class="form-card" style="margin-bottom: 2rem;">
    <h3>Nouvel Emprunt</h3>
    <form action="<?= htmlspecialchars($basePath) ?>/loans/create" method="POST" style="display: flex; gap: 10px; align-items: flex-end;">
        <div class="form-group" style="flex: 1;">
            <label>Adhérent</label>
            <select name="user_id" required>
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m['id'] ?>">
                            <?= htmlspecialchars($m['nom'] . ' ' . $m['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Aucun adhérent disponible</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group" style="flex: 1;">
            <label>Document</label>
            <select name="document_id" required>
                <?php if (!empty($docs)): ?>
                    <?php foreach ($docs as $d): ?>
                        <?php if ($d['disponible'] ?? true): ?>
                            <option value="<?= $d['id'] ?>">
                                <?= htmlspecialchars($d['titre']) ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Aucun document disponible</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Valider l'emprunt</button>
        </div>
    </form>
</div>

<h3>Emprunts en cours</h3>
<table>
    <thead>
        <tr>
            <th>Adhérent</th>
            <th>Document</th>
            <th>Date Emprunt</th>
            <th>Retour Prévu</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($loans)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    Aucun emprunt en cours
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($loans as $loan): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($loan['nom'] . ' ' . $loan['prenom']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($loan['titre']) ?>
                </td>
                <td>
                    <?= date('d/m/Y', strtotime($loan['date_emprunt'])) ?>
                </td>
                <td>
                    <?php
                    $date = strtotime($loan['date_retour_prevu']);
                    $isOverdue = $date < time();
                    ?>
                    <span class="status-badge <?= $isOverdue ? 'status-overdue' : 'status-ok' ?>">
                        <?= date('d/m/Y', $date) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= htmlspecialchars($basePath) ?>/loans/return?id=<?= $loan['id'] ?>" class="btn btn-sm">Enregistrer Retour</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>