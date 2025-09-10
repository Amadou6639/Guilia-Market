<?php

// CategoryController.php - Contrôleur pour la gestion des catégories
// Ce contrôleur gère la logique de l'application pour les requêtes sur les catégories.

require_once 'app/models/Category.php';

class CategoryController {
    private $db;
    private $category;

    // Constructeur pour initialiser la connexion à la base de données et le modèle
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }

    /**
     * Récupère toutes les catégories.
     * @return array
     */
    public function getAllCategories() {
        $stmt = $this->category->read();
        $num = $stmt->rowCount();
        
        $categories_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $category_item = array(
                    "id" => $id,
                    "name" => $name,
                    "created_at" => $created_at
                );
                array_push($categories_arr, $category_item);
            }
        }
        return $categories_arr;
    }

    /**
     * Crée une nouvelle catégorie.
     * @param object $data - Les données de la catégorie à créer.
     * @return array
     */
    public function createCategory($data) {
        $this->category->name = $data->name;

        if ($this->category->create()) {
            http_response_code(201);
            return ["message" => "La catégorie a été créée avec succès."];
        } else {
            http_response_code(503);
            return ["message" => "Impossible de créer la catégorie."];
        }
    }
}

?>
