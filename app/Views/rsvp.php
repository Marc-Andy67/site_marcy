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
    <div class="stars-layer-1"></div>
    <div class="stars-layer-2"></div>
    <div class="stars-sparkle"></div>
    <canvas id="starry-night"></canvas>

    <!-- Include Navbar -->
    <?php require __DIR__ . '/partials/navbar.php'; ?>

    <div class="content rsvp-container">
        <header>
            <h1>Réservez votre place</h1><br>
            <p class="subtitle">Confirmation de présence</p>
        </header>

        <main>
            <?php if (isset($error)): ?>
                <div
                    style="background: rgba(255,0,0,0.2); border: 1px solid #ff4444; padding: 10px; border-radius: 5px; color: #ffcccc; margin-bottom: 20px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/rsvp/submit" method="POST" class="rsvp-form">
                <div class="form-group">
                    <input type="text" name="first_name" placeholder="Prénom" required>
                    <input type="text" name="last_name" placeholder="Nom" required>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email (Obligatoire)" required>
                </div>

                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Numéro de téléphone (Obligatoire)" required
                        pattern="[0-9+\-\. ]{10,20}"
                        title="Format valide requis (chiffres, +, -, . ou espaces, 10-20 caractères)">
                </div>

                <div class="form-group">
                    <input type="number" name="age" placeholder="Votre âge" min="1" max="100" required
                        oninput="if(this.value > 100) this.value = 100;">
                </div>



                <!-- Hidden Attending Input (Always Yes) -->
                <input type="hidden" name="is_attending" value="yes">

                <div class="form-group">
                    <label>Accompagnant (1 maximum) :</label>
                    <input type="number" name="plus_one" id="plus_one" min="0" max="1" value="0"
                        oninput="if(this.value > 1) this.value = 1; if(this.value < 0) this.value = 0;">
                </div>

                <div class="form-group" id="plus_one_age_group" style="display: none;">
                    <input type="number" name="plus_one_age" placeholder="Âge de l'accompagnant" min="1" max="100"
                        style="width: 100%;" oninput="if(this.value > 100) this.value = 100;">
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var plusOneInput = document.getElementById('plus_one');
                        var ageGroup = document.getElementById('plus_one_age_group');

                        function toggleAgeInput() {
                            if (plusOneInput.value > 0) {
                                ageGroup.style.display = 'block';
                            } else {
                                ageGroup.style.display = 'none';
                            }
                        }

                        // Run on load
                        toggleAgeInput();

                        // Run on input change
                        plusOneInput.addEventListener('input', toggleAgeInput);
                    });
                </script>

                <div class="form-group radio-group">
                    <label>Régime Alimentaire :</label>
                    <label><input type="radio" name="dietary_restrictions" value="Régime Normal" checked> Régime
                        Normal</label>
                    <label><input type="radio" name="dietary_restrictions" value="Régime Végétarien"> Régime
                        Végétarien</label>
                </div>

                <div class="form-group">
                    <textarea name="message" placeholder="Un petit mot pour les mariés ?"></textarea>
                </div>

                <button type="submit" class="btn">Confirmer</button>
                <p style="color: #ff4444; text-align: center; margin-top: 15px; font-size: 0.9rem; font-weight: bold;">
                    Vous avez jusqu'au 1er juin pour annuler votre invitation. En cas d'empêchement, merci de contacter
                    directement les mariés.
                </p>
            </form>
        </main>
    </div>

    <script src="/assets/js/stars.js" defer></script>
</body>

</html>