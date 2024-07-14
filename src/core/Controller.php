<?php
namespace App\Core;

abstract class Controller {
    protected function renderView($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../../views/{$view}.html.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}
