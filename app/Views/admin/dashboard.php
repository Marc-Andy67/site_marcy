<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .dashboard-container {
            padding: 6rem 2rem 4rem;
            max-width: 1200px;
            margin: 0 auto;
            margin: 0 auto;
            color: #e0e0e0;
            position: relative;
            z-index: 10;
        }

        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            flex: 1 1 200px;
            max-width: 300px;
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #ffd700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            color: #ccc;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background: rgba(255, 255, 255, 0.05);
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-weight: normal;
            font-size: 1.1rem;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-yes {
            background: rgba(0, 255, 127, 0.2);
            color: #00ff7f;
            border: 1px solid rgba(0, 255, 127, 0.3);
        }

        .status-no {
            background: rgba(255, 99, 71, 0.2);
            color: #ff6347;
            border: 1px solid rgba(255, 99, 71, 0.3);
        }

        .status-pending {
            background: rgba(255, 215, 0, 0.1);
            color: #ffd700;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .btn-action {
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.8rem;
            /* margin-right: 5px; Removed in favor of flex gap */
            height: 30px;
            /* Force height for alignment */
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-approve {
            background: #ffd700;
            color: #000;
        }

        .btn-reject {
            background: rgba(255, 99, 71, 0.8);
            color: #fff;
        }

        .btn-reject:hover {
            background: rgb(255, 99, 71);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
            font-style: italic;
        }

        /* Table Layout Fixes */
        th,
        td {
            vertical-align: middle;
        }

        .col-actions {
            min-width: 220px;
            white-space: nowrap;
        }

        .col-date {
            white-space: nowrap;
            width: 150px;
        }

        .col-status {
            white-space: nowrap;
            width: 120px;
        }

        .col-message {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <div class="dashboard-container">
        <h1
            style="text-align: center; font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 3rem; color: #fff;">
            Tableau de Bord</h1>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-number" style="color:#00ff7f;">
                    <?= $stats['total_attending'] ?>
                </div>
                <div class="stat-label">Invités Confirmés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color:#ffd700;">
                    <?= $stats['pending'] ?>
                </div>
                <div class="stat-label">En Attente</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color:#ff6347;">
                    <?= $stats['refused'] ?>
                </div>
                <div class="stat-label">Refusés (Admin)</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color:#ccc;">
                    <?= $stats['total_declined'] ?>
                </div>
                <div class="stat-label">Déclins (Invités)</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?= $stats['total_responses'] ?>
                </div>
                <div class="stat-label">Réponses Totales</div>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Présence</th>
                        <th class="col-status">Statut</th>
                        <th>Accompagnants</th>
                        <th class="col-message">Message</th>
                        <th class="col-actions">Action</th>
                        <th class="col-date">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($guests)): ?>
                        <tr>
                            <td colspan="9" class="empty-state">Aucune réponse pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($guests as $guest): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($guest['first_name'] . ' ' . $guest['last_name']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($guest['email']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($guest['phone'] ?? '-') ?>
                                </td>
                                <td>
                                    <?php if ($guest['is_attending']): ?>
                                        <span class="status-badge status-yes">OUI</span>
                                    <?php else: ?>
                                        <span class="status-badge status-no">NON</span>
                                    <?php endif; ?>
                                </td>
                                <td class="col-status">
                                    <?php if ($guest['is_approved'] == 1): ?>
                                        <span class="status-badge status-yes">Approuvé</span>
                                    <?php elseif ($guest['is_approved'] == 2): ?>
                                        <span class="status-badge status-no"
                                            style="background:rgba(255,0,0,0.2);border-color:red;color:red;">Refusé</span>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">En attente</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (empty($guest['companions'])): ?>
                                        <span style="color:rgba(255,255,255,0.3);">-</span>
                                    <?php else: ?>
                                        <div style="position:relative;">
                                            <span style="cursor:pointer; display:inline-flex; align-items:center; gap:5px; background:rgba(255,255,255,0.05); padding:3px 10px; border-radius:15px; font-size:0.9rem;"
                                                onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'none' ? 'block' : 'none';">
                                                👤 <?= count($guest['companions']) ?>
                                            </span>
                                            <div style="display:none; position:absolute; top:110%; left:0; background:#1a1a1a; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:10px; width:max-content; z-index:100; box-shadow:0 10px 25px rgba(0,0,0,0.8);">
                                                <?php foreach ($guest['companions'] as $comp): ?>
                                                    <div style="font-size:0.85rem; padding:4px 0; border-bottom:1px solid rgba(255,255,255,0.05);">
                                                        • <?= htmlspecialchars($comp['first_name']) ?>, <?= $comp['age'] ?> ans
                                                        <?= !empty($comp['children_menu']) ? ' <br><span style="color:#ffd700;font-size:0.75rem;margin-left:10px;">✓ Menu enfant</span>' : '' ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="col-message" title="<?= htmlspecialchars($guest['message'] ?? '') ?>">
                                    <?= htmlspecialchars($guest['message'] ?? '-') ?>
                                </td>
                                <td class="col-actions">
                                    <?php if ($guest['is_approved'] == 0): ?>
                                        <div class="action-buttons">
                                            <form action="/admin/approve" method="POST" style="margin:0;">
                                                <input type="hidden" name="guest_id" value="<?= $guest['id'] ?>">
                                                <button type="submit" class="btn-action btn-approve">Approuver</button>
                                            </form>
                                            <form action="/admin/reject" method="POST" style="margin:0;">
                                                <input type="hidden" name="guest_id" value="<?= $guest['id'] ?>">
                                                <button type="submit" class="btn-action btn-reject"
                                                    style="background:#dc3545; color:white;">Refuser</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="col-date" style="font-size: 0.8rem; color: #999;">
                                    <?= date('d/m/Y H:i', strtotime($guest['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="/assets/js/stars.js" defer></script>
    <script>
        function rejectGuest(id) {
            if (confirm('Voulez-vous vraiment refuser cette demande ?')) {
                document.getElementById('reject-form-' + id).submit();
            }
        }
    </script>
</body>

</html>