<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        <?= $title ?>
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <canvas id="starry-night"></canvas>
    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <div class="content" style="text-align: center; padding-top: 8rem;">
        <h1 style="font-family: 'Playfair Display', serif; color: #ffd700; font-size: 3rem; margin-bottom: 2rem;">Merci
            Infiniment !</h1>
        <div
            style="background: rgba(255,255,255,0.1); padding: 3rem; border-radius: 15px; max-width: 600px; margin: 0 auto; backdrop-filter: blur(10px);">
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">
                Votre promesse de don de <strong>
                    <?= htmlspecialchars($donation['amount']) ?> €
                </strong> a bien été enregistrée.
            </p>
            <p>Un email de confirmation vous a été envoyé avec les instructions de paiement.</p>

            <a href="/" class="btn" style="margin-top: 2rem;">Retour à l'accueil</a>
        </div>
    </div>
    <script src="/assets/js/stars.js"></script>
</body>

</html>