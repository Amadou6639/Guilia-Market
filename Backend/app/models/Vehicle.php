<?php

// Vehicle.php - Modèle de données pour les véhicules
// Cette classe gère l'interaction avec la table 'vehicles' dans la base de données.

class Vehicle {

    // Connexion à la base de données et nom de la table
    private $conn;
    private $table_name = "vehicles";

    // Propriétés de l'objet véhicule
    public $id;
    public $brand;
    public $model;
    public $year;
    public $price;
    public $description;
    public $kilometers;
    public $fuel;
    public $created_at;

    // Constructeur avec la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lire tous les véhicules de la base de données.
     * @return PDOStatement
     */
    public function read() {
        $query = "SELECT id, brand, model, year, price, description, kilometers, fuel, created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Créer un nouveau véhicule.
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET brand=:brand, model=:model, year=:year, price=:price, description=:description, kilometers=:kilometers, fuel=:fuel";
        $stmt = $this->conn->prepare($query);
        
        // Nettoyage des données
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->kilometers = htmlspecialchars(strip_tags($this->kilometers));
        $this->fuel = htmlspecialchars(strip_tags($this->fuel));

        // Liaison des valeurs
        $stmt->bindParam(":brand", $this->brand);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":kilometers", $this->kilometers);
        $stmt->bindParam(":fuel", $this->fuel);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // D'autres méthodes pour lire un seul véhicule, mettre à jour et supprimer...
    // public function readOne() { ... }
    // public function update() { ... }
    // public function delete() { ... }
}

?>
