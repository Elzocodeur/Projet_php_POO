<?php
// namespace App\Core;

// abstract class Controller {
//     protected function renderView($view, $data = []) {
//         extract($data);
//         require_once __DIR__ . "/../../views/{$view}.html.php";
//     }

//     protected function redirect($url) {
//         header("Location: {$url}");
//         exit;
//     }
// }



namespace App\Core;

use Symfony\Component\Yaml\Yaml;
use App\Core\Validator\ValidatorInterface;

abstract class Controller {
    protected ValidatorInterface $validator;

    public function __construct() {
        $config = Yaml::parseFile(__DIR__ . '/../config/Services.yaml');
        $validatorClass = $config['Services']['Validator']['class'];
        $this->validator = new $validatorClass();
    }

    protected function renderView($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../../views/{$view}.html.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}

