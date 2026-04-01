<?php
$currentUri = $_SERVER['REQUEST_URI'];
$isHome = ($currentUri == '/' || strpos($currentUri, '/home') !== false || strpos($currentUri, '/index.php') !== false);
?>
<nav class="main-nav <?= !$isHome ? 'static-nav' : '' ?>">
    <button class="menu-toggle" aria-label="Toggle navigation">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <ul class="nav-links">
        <li><a href="/">Accueil</a></li>
        <li><a href="/a-propos">À propos</a></li>
        <li><a href="/dress-code">Dress Code</a></li>
        <li><a href="/programme">Programme</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="/invites">Invités</a></li>
        <?php endif; ?>
        <li><a href="/cagnotte">Cagnotte</a></li>
        <li><a href="/rsvp" class="btn-nav">RSVP</a></li>
    </ul>
</nav>
<script src="/assets/js/mobile-menu.js"></script>