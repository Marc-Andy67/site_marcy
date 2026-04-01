<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        <?= $title ?>
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css?v=2">
</head>

<body>
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <!-- Compte à rebours -->
    <div id="countdown-container">
        <div id="countdown-timer">CHARGEMENT...</div>
    </div>

    <style>
        #countdown-container {
            text-align: center;
            padding: 130px 0 0 0;
            /* Removed bottom padding */
            color: #dcdcdc;
            /* Silver/Text color */
            font-family: 'Cinzel', serif;
            z-index: 10;
            position: relative;
        }

        #countdown-timer {
            display: flex;
            justify-content: center;
            gap: 30px;
            /* Increased gap */
            font-size: 1.4rem;
            /* Increased base font size */
        }

        .time-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .time-unit .number {
            font-size: 2.8rem;
            /* Increased number font size */
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .time-unit .label {
            font-size: 0.8rem;
            text-transform: uppercase;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            #countdown-timer {
                gap: 10px;
            }

            .time-unit .number {
                font-size: 1.5rem;
            }
        }

        /* Override content margin on homepage to bring it closer to countdown */
        .content {
            margin-top: 0 !important;
            padding-top: 1rem !important;
        }
    </style>

    <div class="content">
        <header>
            <h1>Marcy et Leroy</h1>
            <br>
            <p class="subtitle">Une nuit sous les étoiles</p>
        </header>

        <main>
            <section class="intro">
                <h2>Célébrez notre union</h2>
                <div class="date">
                    <?= $weddingDate ?>
                </div>
                <br>
                <a href="/rsvp" class="btn" style="margin-top: 2rem;">Confirmer votre présence</a>
            </section>
        </main>

        <footer>
            <div class="footer-details">
                <div class="footer-info">
                    <p><strong>Martinique</strong></p>
                    <p>Eglise St Jean Baptiste , 8 Rue Alexandre Zonzon, Rivière Salée 97215,Martinique</p>
                    <p>Espace Laguerre / Salle la distillerie</p>
                    <p>Cérémonie à partir de 14h30</p>
                </div>

                <div class="footer-social">
                    <a href="https://instagram.com/iammarcy__" target="_blank" class="btn-social-footer">@Marcy</a>
                    <a href="https://instagram.com/leroy_carpaye" target="_blank" class="btn-social-footer">@Leroy</a>
                </div>
            </div>
            <p class="copyright">&copy; 2026 - Marcy et Leroy - Conçu avec amour</p>
        </footer>
    </div>

    <script src="/assets/js/stars.js"></script>
    <script src="/assets/js/countdown.js"></script>
</body>

</html>