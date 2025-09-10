<?php
// Headers requis pour l'API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Répondre à la requête OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Vérifier la méthode de requête
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Méthode non autorisée"]);
    exit;
}

// Inclure les fichiers nécessaires
include_once '../../config/database.php';
include_once '../../app/models/User.php';
include_once '../../config/core.php';

// --- IMPORTANT ---
// Pour une application de production, installez une bibliothèque JWT via Composer
// Par exemple : composer require firebase/php-jwt
// Puis incluez l'autoloader :
// if (file_exists('../../vendor/autoload.php')) {
//     require_once '../../vendor/autoload.php';
//     use \Firebase\JWT\JWT;
// } else {
    require_once '../../../JWT_mock.php';
// }

// Instancier la base de données et l'objet utilisateur
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Obtenir les données postées
$data = json_decode(file_get_contents("php://input"));

// S'assurer que les données ne sont pas vides
if (!empty($data->email) && !empty($data->password)) {
    $user->email = $data->email;

    try {
        // Vérifier si l'utilisateur existe
        if($user->emailExists()) {
            // Vérifier le mot de passe
            if(password_verify($data->password, $user->password)) {
                // Connexion réussie, générer le token JWT ou session
                $payload = [
                        "id" => $user->id,
                        "email" => $user->email,
                        "firstname" => $user->firstname,
                        "lastname" => $user->lastname,
                        "iat" => time()
                    ];
                $token = JWT::encode($payload,
                    $key, // Clé secrète définie dans core.php
                    'HS256'
                );
                http_response_code(200);
                echo json_encode([
                    "message" => "Connexion réussie.",
                    "token" => $token,
                    "user" => [
                        "id" => $user->id,
                        "firstname" => $user->firstname,
                        "lastname" => $user->lastname,
                        "email" => $user->email
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["message" => "Mot de passe incorrect."]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Utilisateur non trouvé."]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Erreur serveur.", "error" => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Email et mot de passe requis."]);
}