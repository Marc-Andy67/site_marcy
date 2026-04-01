<?php
// Redirection vers le dossier public pour charger l'application correctement
// Assurez-vous que votre configuration Nginx pointe vers le dossier 'public' pour la production
// ou que vous avez les règles de réécriture nécessaires pour gérer les URLs.
header('Location: public/');
exit;
