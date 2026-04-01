<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        <?= $title ?>
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .guest-list-container {
            padding: 6rem 2rem 4rem;
            max-width: 800px;
            margin: 0 auto;
            color: #e0e0e0;
            text-align: center;
        }

        .guest-grid {
            display: grid;
            /* Force at least 2 columns on small screens (min 140px) */
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 1rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .guest-list-container {
                padding: 4rem 1rem;
            }

            .guest-card {
                padding: 1rem;
            }

            .guest-initial {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            .guest-name {
                font-size: 0.9rem;
            }
        }

        .guest-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 12px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .guest-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
            border-color: #ffd700;
        }

        .guest-initial {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #ffd700, #b8860b);
            color: #000;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1rem;
        }

        .guest-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: #fff;
        }

        .no-guests {
            grid-column: 1 / -1;
            padding: 3rem;
            font-style: italic;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <div class="guest-list-container">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 2rem; color: #fff;">Ils
            seront là !</h1>
        <p style="margin-bottom: 2rem; color: #ccc;">Voici la liste des invités qui ont confirmé leur présence pour
            cette nuit magique.</p>

        <div class="guest-grid">
            <?php if (empty($guests)): ?>
                <div class="no-guests">
                    La liste est en cours de mise à jour...
                </div>
            <?php else: ?>
                <?php foreach ($guests as $guest): ?>
                    <div class="guest-card">
                        <div class="guest-initial">
                            <?= strtoupper(substr($guest['first_name'], 0, 1)) ?>
                        </div>
                        <div class="guest-name">
                            <?= htmlspecialchars($guest['first_name'] . ' ' . $guest['last_name']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="/assets/js/stars.js"></script>
</body>

</html>