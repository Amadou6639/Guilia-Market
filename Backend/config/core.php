<?php
// core.php - Fichier de configuration de base
// Afficher les erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Variables utilisées pour le JSON Web Token (JWT)
$key = "VOTRE_CLE_SECRETE_PERSONNELLE"; // Remplacer par une clé secrète forte et unique
$iss = "http://automarket.org"; // Émetteur du token (votre domaine)
$aud = "http://automarket.org"; // Audience du token (votre domaine)
$iat = time(); // Heure d'émission du token
$nbf = $iat; // "Not Before" - le token n'est pas valide avant cette heure
$exp = $iat + (60*60*24); // Expiration du token (ici, 24 heures)
?>