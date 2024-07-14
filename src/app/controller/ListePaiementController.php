<?php

namespace App\App\Controller;

use App\Core\Controller;
use App\App\App;

class ListePaiementController extends Controller
{
    private $listePaiementModel;
    private $detteModel;

    public function __construct()
    {
        $this->listePaiementModel = App::getInstance()->getModel("listepaiement");
        $this->detteModel = App::getInstance()->getModel("dette");
    }

    public function afficherListePaiement()
    {
        $detteId = $_POST['id'] ?? $_GET['id'] ?? '';
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        if ($detteId) {
            $dette = $this->detteModel->getDetteById($detteId);
            $paiements = $this->listePaiementModel->getPaiementsByDetteId($detteId, $offset, $limit);
            $totalPaiements = $this->listePaiementModel->getTotalPaiementsByDetteId($detteId);

            if ($dette && $paiements) {
                $utilisateurModel = App::getInstance()->getModel("utilisateur");
                $utilisateur = $utilisateurModel->findById($dette->utilisateursId);

                if ($utilisateur) {
                    $this->renderView('listepaiement', [
                        'dette' => $dette,
                        'utilisateur' => $utilisateur,
                        'paiements' => $paiements,
                        'total_paiements' => $totalPaiements->total_paiements,
                        'page' => $page,
                        'limit' => $limit
                    ]);
                } else {
                    $this->renderView('listepaiement', ['error' => 'Utilisateur non trouvé.']);
                }
            } else {
                $this->renderView('listepaiement', ['error' => 'Aucun paiement trouvé pour cette dette.']);
            }
        } else {
            $this->renderView('listepaiement', ['error' => 'ID de dette non fourni.']);
        }
    }
}
