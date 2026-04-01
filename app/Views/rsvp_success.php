<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <canvas id="starry-night"></canvas>

    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <div class="content">
        <header>
            <h1>Merci !</h1>
        </header>

        <main>
            <p>Votre réponse a bien été enregistrée.</p>
            <?php if ($guest['is_attending']): ?>
                <p>Nous avons hâte de vous voir !</p>
            <?php else: ?>
                <p>Nous regretterons votre absence.</p>
            <?php endif; ?>

            <a href="/" class="btn" style="margin-top: 2rem;">Retour à l'accueil</a>
        </main>
    </div>

    <script src="/assets/js/stars.js" defer></script>
</body>

</html>