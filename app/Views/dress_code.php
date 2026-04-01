<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css?v=2">
    <style>
        body,
        html {
            margin: 0;
            overflow-x: hidden;
            font-family: 'Montserrat', sans-serif;
            color: #dcdcdc;
            /* Silver text */
        }

        .dress-code-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding-top: 60px;
        }

        .content-block {
            background: rgba(0, 0, 0, 0.6);
            padding: 3rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            max-width: 600px;
            width: 90%;
            text-align: center;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1.5s ease-out;
        }

        h1 {
            font-family: 'Cinzel', serif;
            font-size: 3rem;
            margin-bottom: 2rem;
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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

    <div class="dress-code-container">
        <div class="content-block">
            <div style="display: flex; justify-content: center; align-items: center; gap: 2rem; margin-bottom: 1.5rem;">
                <img id="img-tuxedo" src="/assets/img/tuxedo.avif" alt="Costume" style="height: 100px; width: auto; object-fit: contain;">
                <img id="img-robe" src="/assets/img/robe.avif" alt="Robe" style="height: 100px; width: auto; object-fit: contain;">
            </div>
            <h1>Dress Code</h1>
            <p>Pour cette nuit magique sous les étoiles, nous vous invitons à revêtir votre plus belle tenue.</p>
            <p><strong>Tenue chic , noire et élégante.</strong></p>
            <p>Soyez éblouissants !</p>
            <p>Petit rappel : la tenue exigée est noir uniquement. Si ce n’est pas respecté, il ne sera malheureusement pas possible de participer à l’événement.</p>
        </div>
    </div>

    <script src="/assets/js/stars.js" defer></script>
    <script>
        window.addEventListener('load', function () {
            const images = [document.getElementById('img-tuxedo'), document.getElementById('img-robe')];
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d', { willReadFrequently: true });

            images.forEach(img => {
                if (!img) return;
                const processImage = function () {
                    canvas.width = img.naturalWidth;
                    canvas.height = img.naturalHeight;
                    ctx.drawImage(img, 0, 0);

                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const data = imageData.data;

                    for (let i = 0; i < data.length; i += 4) {
                        const r = data[i];
                        const g = data[i + 1];
                        const b = data[i + 2];
                        if (r > 200 && g > 200 && b > 200) {
                            data[i + 3] = 0;
                        }
                    }
                    ctx.putImageData(imageData, 0, 0);
                    img.src = canvas.toDataURL('image/png');
                    if (img.id === 'img-tuxedo') {
                        // Micro halo blanc très léger pour détacher le noir sur noir
                        img.style.filter = "drop-shadow(0 0 3px rgba(255, 255, 255, 0.4))";
                    } else {
                        img.style.filter = "invert(1) drop-shadow(0 0 10px rgba(255, 215, 0, 0.4))";
                    }
                };

                if (img.complete && img.naturalHeight > 0) {
                    processImage();
                } else {
                    img.onload = processImage;
                }
            });
        });
    </script>
</body>

</html>