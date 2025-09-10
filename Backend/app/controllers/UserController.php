<?php

// UserController.php - Contrôleur pour la gestion des utilisateurs
// Ce contrôleur gère la logique de l'application pour les requêtes sur les utilisateurs.

require_once 'app/models/User.php';

class UserController {
    private $db;
    private $user;

    // Constructeur pour initialiser la connexion à la base de données et le modèle
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    /**
     * Récupère tous les utilisateurs.
     * @return array
     */
    public function getAllUsers() {
        $stmt = $this->user->read();
        $num = $stmt->rowCount();
        
        $users_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user_item = array(
                    "id" => $id,
                    "firstname" => $firstname,
                    "lastname" => $lastname,
                    "email" => $email,
                    "role" => $role,
                    "created_at" => $created_at
                );
                array_push($users_arr, $user_item);
            }
        }
        return $users_arr;
    }

    /**
     * Crée un nouvel utilisateur.
     * @param object $data - Les données de l'utilisateur à créer.
     * @return array
     */
    public function createUser($data) {
        if (!empty($data->email) && !empty($data->password)) {
            $this->user->email = $data->email;
            if ($this->user->emailExists()) {
                http_response_code(409);
                return ["message" => "L'email existe déjà."];
            }

            $this->user->firstname = $data->firstname;
            $this->user->lastname = $data->lastname;
            $this->user->password = $data->password;
            
            if ($this->user->create()) {
                http_response_code(201);
                return ["message" => "L'utilisateur a été créé avec succès."];
            } else {
                http_response_code(503);
                return ["message" => "Impossible de créer l'utilisateur."];
            }
        }
        http_response_code(400);
        return ["message" => "Données incomplètes."];
    }
}
?>
