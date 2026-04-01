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
        .gift-container {
            padding: 6rem 2rem 4rem;
            max-width: 900px;
            margin: 0 auto;
            color: #e0e0e0;
            text-align: center;
        }

        .gift-intro {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 4rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .gift-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .gift-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 2.5rem 2rem;
            border-radius: 15px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .gift-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: block;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: #ffd700;
            margin-bottom: 1rem;
        }

        .iban-box {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin: 1rem 0;
            word-break: break-all;
            border: 1px dashed rgba(255, 255, 255, 0.2);
        }

        .btn-copy {
            background: transparent;
            border: 1px solid #ffd700;
            color: #ffd700;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-copy:hover {
            background: #ffd700;
            color: #000;
        }

        .btn-link {
            display: inline-block;
            background: #ffd700;
            color: #000;
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 1rem;
            transition: background 0.3s ease;
        }

        .btn-link:hover {
            background: #ffed4a;
        }

        .amount-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .btn-amount {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            color: #fff;
            padding: 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-amount:hover,
        .btn-amount.active {
            background: #ffd700;
            color: #000;
            border-color: #ffd700;
            transform: scale(1.05);
        }

        .custom-amount-box {
            position: relative;
            margin-bottom: 1rem;
        }

        .custom-amount-box input {
            width: 100%;
            padding: 0.8rem;
            padding-right: 2.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
        }

        .custom-amount-box input:focus {
            outline: none;
            border-color: #ffd700;
        }

        .currency-symbol {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ffd700;
        }
    </style>
</head>

<body>
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <div class="gift-container">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 2rem; color: #fff;">Liste de
            Mariage</h1>

        <p class="gift-intro">
            Votre présence à nos côtés est le plus beau des cadeaux.
            Si vous souhaitez toutefois participer à nos projets d'avenir (voyage de noces, aménagement de notre nid
            douillet...),
            nous avons mis en place une cagnotte.
        </p>

        <div class="gift-cards">


            <!-- Virement -->
            <div class="gift-card">
                <span class="card-icon">🏦</span>
                <h3 class="card-title">Virement Bancaire</h3>
                <p>Pour une participation directe.</p>
                <div class="iban-box" id="iban-text">FR76 1027 8010 0900 0213 8680 118</div>
                <button class="btn-copy" onclick="copyIBAN()">Copier l'IBAN</button>

                <!-- Phone -->
                <div
                    style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 15px;">
                    <p style="font-size: 0.9rem; margin-bottom: 5px;">Par Numéro :</p>
                    <div class="iban-box" style="margin: 0.5rem 0; font-weight: bold;">06 73 65 33 71
                    </div>
                    <button class="btn-copy" onclick="copyWeroPhone()">Copier le numéro</button>
                </div>

                <!-- Email -->
                <div>
                    <p style="font-size: 0.9rem; margin-bottom: 5px;">Par Email :</p>
                    <div class="iban-box" style="margin: 0.5rem 0; font-weight: bold; word-break: break-all;">
                        marcy.pivert@gmail.com</div>
                    <button class="btn-copy" onclick="copyWeroEmail()">Copier l'émail</button>
                </div>


            </div>

            <!-- Wero Card -->
            <div class="gift-card">
                <span class="card-icon">⚡</span>
                <h3 class="card-title">Wero</h3>
                <p style="margin-bottom: 1.5rem;">Virement instantané</p>

                <div
                    style="background: white; padding: 15px; border-radius: 10px; display: inline-block; margin: 1rem auto;">
                    <img src="/assets/img/qr_code_wero.jpg" alt="QR Code Wero" style="width: 200px; height: auto;">
                </div>

                <!-- Wero Link -->
                <div style="margin-top: 1rem;">
                    <p style="font-size: 0.9rem; margin-bottom: 5px;">Lien de paiement :</p>
                    <div class="iban-box" id="wero-link"
                        style="margin: 0.5rem 0; font-weight: bold; word-break: break-all;">
                        https://share.weropay.eu/p/1/c/l61Lt9xRDa</div>
                    <button class="btn-copy" onclick="copyWeroLink()">Copier le lien</button>
                    <!-- Fallback link for direct click -->
                    <a href="https://share.weropay.eu/p/1/c/l61Lt9xRDa" target="_blank" class="btn-link"
                        style="display: inline-block; margin-top: 10px; font-size: 0.8rem; padding: 0.5rem 1rem;">Ouvrir
                        le lien</a>
                </div>


            </div>

            <!-- Urne -->
            <div class="gift-card" style="grid-column: 1 / -1;">
                <span class="card-icon">✉️</span>
                <h3 class="card-title">L'Urne</h3>
                <p>Une urne sera à votre disposition lors de la réception pour vos enveloppes et petits mots.</p>
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    <img id="urne-img" src="/assets/img/urne.png" alt="Urne de mariage"
                        style="max-width: 250px; height: auto;">
                </div>
            </div>
        </div>
    </div>




    <script src="/assets/js/stars.js"></script>
    <script>
        // Background removal for Urn
        window.addEventListener('load', function () {
            const img = document.getElementById('urne-img');
            // Create canvas dynamically if not present
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Force crossOrigin if needed (though local)
            // img.crossOrigin = "Anonymous"; 

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
                    // Threshold for white
                    if (r > 200 && g > 200 && b > 200) {
                        data[i + 3] = 0; // Alpha 0
                    }
                }
                ctx.putImageData(imageData, 0, 0);
                img.src = canvas.toDataURL('image/png');

                // Optional: apply drop shadow AFTER removing background for nice effect
                // invert(1) makes black lines white for better visibility on dark background
                img.style.filter = "invert(1) drop-shadow(0 0 10px rgba(255, 215, 0, 0.4))";
            };

            if (img.complete) {
                processImage();
            } else {
                img.onload = processImage;
            }
        });


        // Re-enable QRCode library
        // Helper function for robust copying (works on non-secure contexts)
        function copyToClipboard(text, successMessage) {
            if (navigator.clipboard && window.isSecureContext) {
                // Secure context (HTTPS or localhost)
                navigator.clipboard.writeText(text).then(() => {
                    alert(successMessage);
                }, () => {
                    alert("Erreur lors de la copie.");
                });
            } else {
                // Fallback for non-secure context (e.g. mobile on local network)
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-9999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    alert(successMessage);
                } catch (err) {
                    alert("Erreur lors de la copie. Veuillez copier manuellement.");
                }
                document.body.removeChild(textArea);
            }
        }

        function copyIBAN() {
            const iban = document.getElementById('iban-text').innerText;
            copyToClipboard(iban, 'IBAN copié !');
        }

        function copyWeroPhone() {
            const phone = "0673653371";
            copyToClipboard(phone, 'Numéro Wero copié !');
        }

        function copyWeroEmail() {
            const email = "marcy.pivert@gmail.com";
            copyToClipboard(email, 'Email Wero copié !');
        }

        function copyWeroLink() {
            const link = document.getElementById('wero-link').innerText;
            copyToClipboard(link, 'Lien Wero copié !');
        }




    </script>
</body>

</html>