<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .about-container {
            padding: 6rem 2rem 4rem;
            max-width: 1200px;
            margin: 0 auto;
            color: #e0e0e0;
        }

        .section-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        /* Couple Grid */
        .couple-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 6rem;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
        }

        /* Updated Profile Image Style */
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.2);
            object-fit: cover;
            /* Ensure photo covers circle without distortion */
            display: block;
            /* Changed from flex */
        }

        .profile-header {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .constellation-icon {
            display: none !important;
            /* Hidden as moved to modal */
        }

        @keyframes pulse-star {
            0% {
                opacity: 0.7;
            }

            50% {
                opacity: 1;
                filter: drop-shadow(0 0 8px #e0e0e0);
            }

            100% {
                opacity: 0.7;
            }
        }



        .profile-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #fff;
            /* White instead of Gold */
            text-shadow: 0 0 5px rgba(192, 192, 192, 0.3);
        }

        .profile-desc {
            font-style: italic;
            line-height: 1.6;
            color: #ccc;
            text-align: justify;
        }

        /* Story Section */
        .story-section {
            background: rgba(0, 0, 0, 0.4);
            padding: 3rem;
            border-radius: 15px;
            margin-bottom: 4rem;
            border-left: 3px solid #C0C0C0;
            /* Silver instead of Gold */
        }

        .story-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 1.5rem;
        }

        .stars-quote {
            text-align: center;
            font-size: 1.5rem;
            font-style: italic;
            color: #C0C0C0;
            /* Silver instead of Gold */
            margin-top: 2rem;
        }



        @media (max-width: 768px) {
            .about-container {
                padding: 4rem 1rem;
            }

            .couple-grid {
                /* Force 2 columns even on mobile */
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                /* Smaller gap */
                margin-bottom: 3rem;
            }

            .profile-card {
                padding: 1rem;
                /* Smaller padding */
            }

            .profile-img {
                width: 80px;
                /* Smaller image */
                height: 80px;
                font-size: 1.5rem;
                border-width: 2px;
            }

            .profile-header {
                gap: 0.5rem;
                margin-bottom: 1rem;
                flex-direction: column;
            }

            .profile-name {
                font-size: 1.2rem;
                /* Smaller name */
            }

            .profile-desc {
                font-size: 0.8rem;
                /* Smaller text */
                line-height: 1.4;
                text-align: left;
                /* Easier to read in narrow columns */
            }

            .constellation-icon {
                width: 100px;
                /* Smaller icon */
                height: 100px;
                margin: 1rem auto;
            }
        }

        /* Read More Button */
        .read-more-btn {
            display: none;
            margin-top: 1rem;
            padding: 0.5rem 1.5rem;
            background: transparent;
            border: 1px solid #C0C0C0;
            /* Silver */
            color: #C0C0C0;
            border-radius: 20px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .read-more-btn:hover {
            background: #C0C0C0;
            color: #000;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: #1a1a1a;
            width: 90%;
            max-width: 500px;
            max-height: 85vh;
            /* Slightly reduced to ensure it fits mobile screens comfortably */
            overflow-y: auto;
            border-radius: 15px;
            padding: 2rem;
            padding-bottom: 4rem;
            /* Extra padding at bottom for scrolling space */
            border: 1px solid #C0C0C0;
            /* Silver */
            transform: translateY(20px);
            transition: transform 0.3s ease;
            position: relative;
            text-align: center;
            -webkit-overflow-scrolling: touch;
            /* smooth scrolling */
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .modal-img-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: #1a1a1a;
            /* Match modal background */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: rgba(255, 255, 255, 0.5);
            border: 3px solid #C0C0C0;
            /* Silver */
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #fff;
            /* White */
            margin-bottom: 1.5rem;
        }

        .modal-text {
            color: #e0e0e0;
            line-height: 1.8;
            text-align: justify;
            font-size: 1rem;
        }

        .modal-constellation {
            width: 150px;
            height: 150px;
            margin: 2rem auto 0;
            /* Align center */
            /* Removed drop-shadow to avoid contour/box artifact */
            display: flex;
            justify-content: center;
            align-items: center;
            background: transparent !important;
            /* Force transparency */
        }

        .modal-constellation svg {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }

        @media (max-width: 768px) {
            .read-more-btn {
                display: inline-block;
                margin-top: auto;
                font-size: 0.8rem;
                padding: 0.4rem 1.2rem;
            }

            .profile-card {
                display: flex;
                flex-direction: column;
                height: 100%;
                justify-content: flex-start;
            }

            .profile-desc-wrapper {
                flex: 1;
                /* Takes available space */
                overflow: hidden;
            }

            .profile-desc {
                /* Truncate text */
                display: -webkit-box;
                -webkit-line-clamp: 4;
                /* Show only 4 lines */
                -webkit-box-orient: vertical;
                overflow: hidden;
                margin-bottom: 0.5rem;
            }

            .constellation-icon {
                display: block;
                /* Unhide in grid */
                width: 80px;
                height: 80px;
                margin: 0.5rem auto 0;
            }
        }

        /* Desktop Constellations */
        .desktop-constellation {
            display: block;
            width: 280px;
            height: auto;
            margin: 1rem auto 0;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .desktop-constellation {
                display: none !important;
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

    <div class="about-container">
        <h1 class="section-title">Les Mariés</h1>

        <div class="couple-grid">
            <div class="profile-card" data-name="Marcy" data-img="/assets/img/marcy.png">
                <div class="profile-header">
                    <img loading="lazy" src="/assets/img/marcy.png" alt="Marcy" class="profile-img">
                </div>
                <h2 class="profile-name">Marcy</h2>
                <div class="profile-desc-wrapper">
                    <p class="profile-desc">
                        Âgée de 28 ans et d’origine martiniquaise, elle est une personne bienveillante et attentive aux
                        autres. Comme une vraie Gémeau, curieuse et pleine de vivacité, elle dégage une lumière douce et
                        apaisante, à l’image des étoiles qui la fascinent et qu’elle aime observer lorsque la nuit
                        tombe.
                        Attachée à ses racines et à ses valeurs, elle avance avec sensibilité et légèreté, des qualités
                        qu’elle reflète aussi dans son métier d’infirmière, guidée comme par une étoile discrète mais
                        constante.
                    </p>
                </div>
                <svg class="desktop-constellation" viewBox="0 0 500 500" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <filter id="invert-gemini">
                            <feColorMatrix in="SourceGraphic" type="matrix"
                                values="-1 0 0 0 1  0 -1 0 0 1  0 0 -1 0 1  0 0 0 1 0" />
                        </filter>
                        <mask id="mask-gemini">
                            <image href="/assets/img/constellation_gemini_v3.png" width="100%" height="100%"
                                filter="url(#invert-gemini)" preserveAspectRatio="xMidYMid meet" />
                        </mask>
                    </defs>
                    <rect x="0" y="0" width="100%" height="100%" fill="#ffffff" mask="url(#mask-gemini)" />
                </svg>
                <button class="read-more-btn">Lire plus</button>

                <!-- Hidden full content for modal -->
                <div class="full-content" style="display:none;">
                    Âgée de 28 ans et d’origine martiniquaise, elle est une personne bienveillante et attentive aux
                    autres. Comme une vraie Gémeau, curieuse et pleine de vivacité, elle dégage une lumière douce et
                    apaisante, à l’image des étoiles qui la fascinent et qu’elle aime observer lorsque la nuit tombe.
                    Attachée à ses racines et à ses valeurs, elle avance avec sensibilité et légèreté, des qualités
                    qu’elle reflète aussi dans son métier d’infirmière, guidée comme par une étoile discrète mais
                    constante.
                </div>
                <div class="constellation-html" style="display:none;">
                    <img loading="lazy" src="/assets/img/constellation_gemini_v3.png" alt="Constellation Gémeaux"
                        style="width:100%; height:100%; filter: invert(1); mix-blend-mode: screen; opacity: 0.8;" />
                </div>
            </div>
            <div class="profile-card" data-name="Leroy" data-img="/assets/img/leroy.jpg">
                <div class="profile-header">
                    <img loading="lazy" src="/assets/img/leroy.jpg" alt="Leroy" class="profile-img">
                </div>
                <h2 class="profile-name">Leroy</h2>
                <div class="profile-desc-wrapper">
                    <p class="profile-desc">
                        Âgé de 29 ans, c'est un homme au grand cœur et à l’esprit aventurier, marqué par la force
                        tranquille
                        des Capricornes. Originaire de Martinique, il porte en lui l’amour de son île et une curiosité
                        sans
                        fin pour le monde qui l’entoure. Fasciné par les étoiles, il aime lever les yeux vers le ciel,
                        comme
                        pour y puiser sa force et sa sérénité. Guidé par ses valeurs et par son destin, il avance avec
                        détermination et bienveillance, qualités qu’il exprime aussi dans son engagement en tant que
                        militaire, fidèle et lumineux, tel un astre sûr dans la nuit.
                    </p>
                </div>
                <svg class="desktop-constellation" viewBox="0 0 500 500" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <filter id="invert-capricorn">
                            <feColorMatrix in="SourceGraphic" type="matrix"
                                values="-1 0 0 0 1  0 -1 0 0 1  0 0 -1 0 1  0 0 0 1 0" />
                        </filter>
                        <mask id="mask-capricorn-desktop">
                            <image href="/assets/img/constellation_capricorn.png" width="100%" height="100%"
                                filter="url(#invert-capricorn)" preserveAspectRatio="xMidYMid meet" />
                        </mask>
                    </defs>
                    <rect x="0" y="0" width="100%" height="100%" fill="#ffffff" mask="url(#mask-capricorn-desktop)" />
                </svg>
                <button class="read-more-btn">Lire plus</button>
                <div class="constellation-icon" title="Capricorne">
                    <svg viewBox="0 0 500 500" width="200" height="200" preserveAspectRatio="xMidYMid meet">
                        <defs>
                            <filter id="invert">
                                <feColorMatrix in="SourceGraphic" type="matrix"
                                    values="-1 0 0 0 1  0 -1 0 0 1  0 0 -1 0 1  0 0 0 1 0" />
                            </filter>
                            <mask id="capricorn-mask">
                                <!-- Invert colors: Black lines become White (opaque in mask), White BG becomes Black (transparent in mask) -->
                                <image href="/assets/img/constellation_capricorn.png" width="100%" height="100%"
                                    filter="url(#invert)" preserveAspectRatio="xMidYMid meet" />
                            </mask>
                        </defs>
                        <!-- Fill with Silver, applied through mask -->
                        <rect x="0" y="0" width="100%" height="100%" fill="#e0e0e0" mask="url(#capricorn-mask)" />
                    </svg>
                </div>
                <!-- Hidden full content for modal -->
                <div class="full-content" style="display:none;">
                    Âgé de 29 ans, c'est un homme au grand cœur et à l’esprit aventurier, marqué par la force tranquille
                    des Capricornes. Originaire de Martinique, il porte en lui l’amour de son île et une curiosité sans
                    fin pour le monde qui l’entoure. Fasciné par les étoiles, il aime lever les yeux vers le ciel, comme
                    pour y puiser sa force et sa sérénité. Guidé par ses valeurs et par son destin, il avance avec
                    détermination et bienveillance, qualités qu’il exprime aussi dans son engagement en tant que
                    militaire, fidèle et lumineux, tel un astre sûr dans la nuit.
                </div>
                <div class="constellation-html" style="display:none;">
                    <img loading="lazy" src="/assets/img/constellation_capricorn.png" alt="Constellation Capricorne"
                        style="width:100%; height:100%; filter: invert(1); mix-blend-mode: screen; opacity: 0.8;" />
                </div>
            </div>
        </div>

        <h1 class="section-title">Notre Histoire</h1>

        <div class="story-section">
            <p class="story-text">
                Marcy et Leroy se connaissent depuis toujours.

Depuis l’enfance, ils étaient les meilleurs amis du monde, deux enfants de la Martinique qui grandissaient sous le même soleil, les yeux levés vers le même ciel étoilé.
La vie les a séparés. Le temps a passé. Mais à l’adolescence, ils se sont retrouvés, et quelque chose s’est rallumé. Cette fois, c’était différent. C’était plus.
Vingt ans plus tard, ils reviennent là où tout a commencé. Sous ce ciel martiniquais qui les a vus enfants, qui les a vus se retrouver, et qui les verra aujourd’hui se dire oui.
Certaines histoires ne s’inventent pas.

            </p>
        </div>

    </div>

    <!-- Profile Modal -->
    <div id="profile-modal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <div class="modal-img-container" id="modal-img"></div>
            <h2 class="modal-title" id="modal-title"></h2>
            <div class="modal-text" id="modal-desc"></div>
            <div class="modal-constellation" id="modal-constellation"></div>
        </div>
    </div>

    <script src="/assets/js/stars.js" defer></script>
    <script src="/assets/js/profile-modal.js" defer></script>
</body>

</html>