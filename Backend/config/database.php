<?php
// database.php - Fichier de configuration de la base de données

class Database {
    // Spécifiez vos propres informations de connexion à la base de données
    private $host = "localhost";
    private $db_name = "AutoMarket"; // Base de données à créer
    private $username = "amadou"; // Votre nom d'utilisateur de BDD
    private $password = "66396816"; // Votre mot de passe de BDD
    public $conn;

    // Obtenir la connexion à la base de données
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {            
            // En cas d'erreur de connexion, on envoie une réponse JSON propre
            // au lieu d'un simple message d'erreur texte.
            http_response_code(503); // Service Unavailable
            echo json_encode(
                array("message" => "Erreur de connexion à la base de données.")
            );
            // On arrête le script pour ne pas continuer avec une connexion nulle.
            exit();
        }
        return $this->conn;
    }
}
?>