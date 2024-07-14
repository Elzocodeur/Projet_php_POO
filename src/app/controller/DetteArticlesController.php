<?php namespace App\App\Controller;

use App\Core\Controller;
use App\App\App;

class DetteArticlesController extends Controller {
    private $detteModel;

    public function __construct() {
        $this->detteModel = App::getInstance()->getModel("dette");
    }

    public function afficherArticles() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $detteId = $_POST['articles'] ?? '';

            $dette = $this->detteModel->getDetteById($detteId);
            $articles = $this->detteModel->articles($detteId);
            $utilisateur = $this->detteModel->utilisateur($dette->utilisateursId);

            $this->renderView('dettearticles', [
                'dette' => $dette,
                'articles' => $articles,
                'utilisateur' => $utilisateur
            ]);
        } else {
            $this->renderView('dettesarticles', ['error' => 'Aucune dette sélectionnée.']);
        }
    }
}
