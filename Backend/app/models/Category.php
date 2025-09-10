<?php

// Category.php - Modèle de données pour les catégories
// Cette classe gère l'interaction avec la table 'categories' dans la base de données.

class Category {

    // Connexion à la base de données et nom de la table
    private $conn;
    private $table_name = "categories";

    // Propriétés de l'objet catégorie
    public $id;
    public $name;
    public $created_at;

    // Constructeur avec la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lire toutes les catégories de la base de données.
     * @return PDOStatement
     */
    public function read() {
        $query = "SELECT id, name, created_at FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Créer une nouvelle catégorie.
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name";
        $stmt = $this->conn->prepare($query);
        
        // Nettoyage des données
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Liaison des valeurs
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

?>
