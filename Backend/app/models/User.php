<?php

// User.php - Modèle de données pour les utilisateurs
// Cette classe gère l'interaction avec la table 'users' dans la base de données.

class User {

    // Connexion à la base de données et nom de la table
    private $conn;
    private $table_name = "users";

    // Propriétés de l'objet utilisateur
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $role;
    public $created_at;

    // Constructeur avec la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lire tous les utilisateurs de la base de données.
     * @return PDOStatement
     */
    public function read() {
        $query = "SELECT id, firstname, lastname, email, role, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Créer un nouvel utilisateur.
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET firstname=:firstname, lastname=:lastname, email=:email, password=:password";
        $stmt = $this->conn->prepare($query);
        
        // Nettoyage des données
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Hachage du mot de passe
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        
        // Liaison des valeurs
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $password_hash);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Vérifier si un email existe.
     * @return bool
     */
    public function emailExists() {
        $query = "SELECT id, firstname, lastname, password FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->password = $row['password']; // Mot de passe haché
            return true;
        }
        return false;
    }
}

?>
