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
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #000;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 15px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 2rem;
            color: #ffd700;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #ccc;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
        }

        input:focus {
            outline: none;
            border-color: #ffd700;
        }

        button {
            width: 100%;
            padding: 1rem;
            background: #ffd700;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background: #ffed4a;
        }

        .error {
            color: #ff4d4d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .back-link {
            display: block;
            margin-top: 1.5rem;
            color: #999;
            text-decoration: none;
            font-size: 0.8rem;
        }

        .back-link:hover {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <div class="login-container">
        <h1>Connexion Admin</h1>

        <?php if (isset($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <div class="form-group">
                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>

        <a href="/" class="back-link">Retour au site</a>
    </div>

    <script src="/assets/js/stars.js"></script>
</body>

</html>