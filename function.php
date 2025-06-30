<?php

// Fonction pour échapper les chaînes (sécurité XSS)
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Fonction pour formater le prix
function format_price($price) {
    return number_format($price, 2, ',', ' ') . ' €';
}

// Fonction pour vérifier si un utilisateur est connecté
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Ajoute ici d'autres fonctions utiles pour ton projet...