<h2>Mes Emprunts</h2>

<table>
    <thead>
        <tr>
            <th>Document</th>
            <th>Auteur</th>
            <th>Emprunté le</th>
            <th>Retour Prévu</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($history)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    Aucun emprunt enregistré
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($history as $loan): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($loan['titre']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($loan['auteur']) ?>
                </td>
                <td>
                    <?= date('d/m/Y', strtotime($loan['date_emprunt'])) ?>
                </td>
                <td>
                    <?= date('d/m/Y', strtotime($loan['date_retour_prevu'])) ?>
                </td>
                <td>
                    <?php if ($loan['date_retour_reel']): ?>
                        <span class="badge badge-success">Retourné le
                            <?= date('d/m/Y', strtotime($loan['date_retour_reel'])) ?>
                        </span>
                    <?php else: ?>
                        <?php
                        $date = strtotime($loan['date_retour_prevu']);
                        $isOverdue = $date < time();
                        ?>
                        <span class="badge <?= $isOverdue ? 'badge-error' : 'badge-livre' ?>">
                            <?= $isOverdue ? 'En retard' : 'En cours' ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>