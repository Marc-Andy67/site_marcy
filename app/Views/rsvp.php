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

                <div id="companions-wrapper"></div>
                <button type="button" id="add-companion-btn" class="btn" style="width: 100%; margin-bottom: 2rem; font-size: 0.9rem;">+ Ajouter un accompagnant</button>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const wrapper = document.getElementById('companions-wrapper');
                        const addBtn = document.getElementById('add-companion-btn');
                        let companionIndex = 0;

                        addBtn.addEventListener('click', function() {
                            if (wrapper.children.length >= 3) return;
                            
                            const div = document.createElement('div');
                            div.className = 'form-group companion-block';
                            div.style.background = 'rgba(255,255,255,0.02)';
                            div.style.padding = '15px';
                            div.style.borderRadius = '5px';
                            div.style.border = '1px solid rgba(255,255,255,0.2)';
                            div.style.marginBottom = '15px';
                            div.style.position = 'relative';

                            div.innerHTML = `
                                <h4 style="margin: 0 0 10px 0; font-family: var(--font-body); font-weight: normal; font-size: 1rem; color: var(--accent);">Accompagnant</h4>
                                <button type="button" title="Retirer" style="position:absolute; top:12px; right:15px; background:transparent; border:none; color:rgba(255,80,80,0.8); font-size:1.2rem; cursor:pointer;" onclick="this.parentElement.remove(); checkCount();">✖</button>
                                
                                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                                    <input type="text" name="companions[${companionIndex}][first_name]" placeholder="Prénom" style="background: rgba(0,0,0,0.2);" required>
                                    <input type="number" name="companions[${companionIndex}][age]" placeholder="Âge" min="1" max="100" style="background: rgba(0,0,0,0.2);" required oninput="if(this.value > 100) this.value = 100;">
                                    <label style="font-size:0.9rem; margin-top:5px; display:flex; align-items:center; gap:8px; cursor:pointer;">
                                        <input type="checkbox" name="companions[${companionIndex}][children_menu]" value="1" style="width:20px; height:20px; margin:0; cursor:pointer;">
                                        <span>Menu enfant (moins de 12 ans)</span>
                                    </label>
                                </div>
                            `;
                            
                            wrapper.appendChild(div);
                            companionIndex++;
                            checkCount();
                        });

                        window.checkCount = function() {
                            if (wrapper.children.length >= 3) {
                                addBtn.style.display = 'none';
                            } else {
                                addBtn.style.display = 'inline-block';
                            }
                        };
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