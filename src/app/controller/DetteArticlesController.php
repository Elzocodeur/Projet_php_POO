<?php namespace App\App\Controller;

use App\Core\Controller;
use App\App\App;

class DetteArticlesController extends Controller {
    private $detteModel;

    public function __construct() {
        $this->detteModel = App::getInstance()->getModel("dette");
    }

    public function afficherArticles() {
        $detteId = $_POST['articles'] ?? $_GET['detteId'] ?? null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 2;

        if ($detteId) {
            $dette = $this->detteModel->getDetteById($detteId);
            $articles = $this->detteModel->articles($detteId);
            $utilisateur = $this->detteModel->utilisateur($dette->utilisateursId);

            $totalArticles = count($articles);
            $totalPages = ceil($totalArticles / $perPage);
            $offset = ($page - 1) * $perPage;

            $paginatedArticles = array_slice($articles, $offset, $perPage);

            $this->renderView('dettearticles', [
                'dette' => $dette,
                'articles' => $paginatedArticles,
                'utilisateur' => $utilisateur,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'detteId' => $detteId
            ]);
        } else {
            $this->renderView('dettesarticles', ['error' => 'Aucune dette sélectionnée.']);
        }
    }
}