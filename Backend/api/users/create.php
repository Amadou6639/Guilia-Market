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
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
    exit;
}
// Instancier la base de données et l'objet utilisateur
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// Obtenir les données postées depuis le frontend (en JSON)
$data = json_decode(file_get_contents("php://input"));

// S'assurer que les données ne sont pas vides
if (
    !empty($data->firstname) &&
    !empty($data->lastname) &&
    !empty($data->email) &&
    !empty($data->password)
) {
    // Assigner les valeurs des propriétés de l'utilisateur
    $user->firstname = $data->firstname;
    $user->lastname = $data->lastname;
    $user->email = $data->email;
    $user->password = $data->password;

    try {
        // Vérifier si l'email existe déjà pour éviter les doublons
        if($user->emailExists()) {
            http_response_code(400); // Bad Request
            echo json_encode(array("message" => "Impossible de créer l'utilisateur. L'adresse email est déjà utilisée."));
        } else {
            // Créer l'utilisateur
            if($user->create()) {
                http_response_code(201); // Created
                echo json_encode(array("message" => "Utilisateur créé avec succès. Vous pouvez maintenant vous connecter."));
            } else {
                http_response_code(503); // Service Unavailable
                echo json_encode(array("message" => "Impossible de créer l'utilisateur. Une erreur est survenue."));
            }
        }
    } catch (Exception $e) {
        // En cas d'erreur de base de données (ex: table non trouvée), on envoie une réponse JSON
        http_response_code(503); // Service Unavailable
        // Pour le débogage, on peut inclure le message d'erreur. En production, un message générique est préférable.
        echo json_encode(array("message" => "Une erreur de base de données est survenue.", "error" => $e->getMessage()));
    }
} else {
    // Informer l'utilisateur que les données sont incomplètes
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Impossible de créer l'utilisateur. Les données sont incomplètes."));
}