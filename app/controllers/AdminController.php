<?php
// TODO Je n'arrive pas a afficher les missions et ressources. 
// [x] Attention récupération de lastid avec ma la façon que j'ai construit ma classe Database.

namespace App\Controllers;

use App\Models\Missions;
use App\Models\Resources;
// use App\Services\SessionManager;

class AdminController {
    private $twig;
    private Missions $mission;
    private Resources $resource;

    public function __construct($twig) {
        $this->twig = $twig;
        $this->mission = new Missions();
        $this->resource = new Resources();
    }

    function index() {

        // SessionManager::init();
        session_start();
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /');
            exit;
        }

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            switch (array_key_first($_POST)) {
                case 'add_mission':
                    $mission_name = $_POST['add_mission']['mission_name'];
                    $resource_id = intval($_POST['add_mission']['resource_id']);
                    $resource_quantity = intval($_POST['add_mission']['resource_quantity']);
                
                    // Vérifier si la resource est disponible en quantité suffisante
                    $resource = $this->resource->getResource($resource_id);
                
                    if ($resource && $resource['quantity'] >= $resource_quantity) {
                
                        $this->resource->updateResource($resource_id,$resource_quantity);
                
                        $mission_id = $this->mission->createMission($mission_name);
                
                        $this->resource->createResourceUsage($mission_id, $resource_id, $resource_quantity);
                        
                    } else {
                        $message = "Quantité insuffisante pour allouer cette reccource.";
                    }
                    break;

                case 'update_mission':
                    
                    $mission_id = intval($_POST['update_mission']['mission_id']);
                    $new_status = $_POST['update_mission']['new_status'];
                
                    $allowed_status = [
                        'planifiée',
                        'en cours',
                        'terminée'
                
                    ];
                
                    if (!in_array($new_status,$allowed_status)) {
                        $message = 'Statut invalide !';
                    } else {
                        $this->mission->updateMission($mission_id, $new_status);
                    }
                
                    break;

                case 'update_resource':
                    $new_quantity = $_POST['update_resource']['new_quantity'];
                    $id = $_POST['update_resource']['id'];
                    if (is_numeric($new_quantity)) {
                        $this->resource->updateResource($id,$new_quantity,false);
                        $message = [
                            'message' => "Resource mise à jour avec succés !",
                            'status' => "error",
                        ];
                    } else {
                        $message = [
                            'message' => "Une erreur est survenue lors de la mise a jour d'une resource",
                            'status' => "error",
                        ];
                    }
                    break;
                
                default:
                    $message = "Erreur du traitement de la requête";
                    break;
            }

        }
        
        $resources = $this->resource->getResources();
        $missions = $this->mission->getMissions();
        
        // Calcul du pourcentage d'invasion
        $total_missions = $this->mission->totalMission();
        $completed_missions = $this->mission->totalMissionCompleted();
        
        $invasion_percentage = ($total_missions > 0) ? ($completed_missions / $total_missions) * 100 : 0;
        $invasion = number_format($invasion_percentage, 2);

        echo $this->twig->render('admin/dashboard.html.twig', [
            'resources' => $resources,
            'missions' => $missions,
            'invasion' => $invasion,
            'msg' => $message,
        ]);
    }
}
