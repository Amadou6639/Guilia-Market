<?php

// VehicleController.php - Contrôleur pour la gestion des véhicules
// Ce contrôleur gère la logique de l'application pour les requêtes sur les véhicules.

require_once 'app/models/Vehicle.php';

class VehicleController {
    private $db;
    private $vehicle;

    // Constructeur pour initialiser la connexion à la base de données et le modèle
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->vehicle = new Vehicle($this->db);
    }

    /**
     * Récupère tous les véhicules.
     * @return array
     */
    public function getAllVehicles() {
        $stmt = $this->vehicle->read();
        $num = $stmt->rowCount();
        
        $vehicles_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $vehicle_item = array(
                    "id" => $id,
                    "brand" => $brand,
                    "model" => $model,
                    "year" => $year,
                    "price" => $price,
                    "description" => html_entity_decode($description),
                    "kilometers" => $kilometers,
                    "fuel" => $fuel,
                    "created_at" => $created_at
                );
                array_push($vehicles_arr, $vehicle_item);
            }
        }
        return $vehicles_arr;
    }

    /**
     * Crée un nouveau véhicule.
     * @param object $data - Les données du véhicule à créer.
     * @return array
     */
    public function createVehicle($data) {
        $this->vehicle->brand = $data->brand;
        $this->vehicle->model = $data->model;
        $this->vehicle->year = $data->year;
        $this->vehicle->price = $data->price;
        $this->vehicle->description = $data->description;
        $this->vehicle->kilometers = $data->kilometers;
        $this->vehicle->fuel = $data->fuel;

        if ($this->vehicle->create()) {
            http_response_code(201);
            return ["message" => "Le véhicule a été créé avec succès."];
        } else {
            http_response_code(503);
            return ["message" => "Impossible de créer le véhicule."];
        }
    }
    
    // Vous pouvez ajouter d'autres méthodes pour la lecture, la mise à jour et la suppression.
    // public function getVehicle($id) { ... }
    // public function updateVehicle($data) { ... }
    // public function deleteVehicle($id) { ... }
}

?>
