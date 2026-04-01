<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Timeline Specific CSS */
        .timeline-container {
            padding: 6rem 1rem 4rem;
            /* Top padding for navbar */
            max-width: 800px;
            margin: 0 auto;
            color: #e0e0e0;
        }

        .page-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #a0a0a0;
            margin-bottom: 4rem;
        }

        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 2px;
            background: linear-gradient(to bottom, transparent, #fff, transparent);
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .timeline-content {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 45%;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.1);
        }

        .timeline-item.left .timeline-content {
            margin-right: auto;
            text-align: right;
        }

        .timeline-item.right .timeline-content {
            margin-left: auto;
            text-align: left;
        }

        .timeline-time {
            font-family: 'Cinzel', serif;
            font-size: 1.5rem;
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .timeline-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin: 0.5rem 0;
            color: #fff;
        }

        .timeline-desc {
            color: #ccc;
            font-size: 1rem;
            line-height: 1.6;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 2rem;
            width: 16px;
            height: 16px;
            background: #fff;
            border-radius: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 10px #fff, 0 0 20px #fff;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 20px;
            }

            .timeline-item {
                justify-content: flex-start;
            }

            .timeline-item::after {
                left: 20px;
            }

            .timeline-content {
                width: calc(100% - 60px);
                margin-left: 60px !important;
                text-align: left !important;
            }
        }
    </style>
</head>

<body>
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <div class="container timeline-container">
        <h1 class="page-title">Le Programme</h1>
        <p class="page-subtitle">Déroulement de notre nuit étoilée</p>

        <div class="timeline">
            <?php foreach ($events as $index => $event): ?>
                <div class="timeline-item <?php echo $index % 2 === 0 ? 'left' : 'right'; ?>">
                    <div class="timeline-content">
                        <div class="timeline-time"><?php echo htmlspecialchars($event['time']); ?></div>
                        <div class="timeline-icon"><?php echo $event['icon']; ?></div>
                        <h3 class="timeline-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p class="timeline-desc"><?php echo htmlspecialchars($event['desc']); ?></p>
                        <?php if (isset($event['address'])): ?>
                            <p class="timeline-address"
                                style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 10px; font-size: 0.95rem; color: #fff;">
                                <?php echo $event['address']; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="/assets/js/stars.js" defer></script>
</body>

</html>