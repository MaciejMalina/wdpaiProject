<?php

class AppController {

    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function isDelete(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function render(string $template = null, array $variables = []) {
        // Ustalanie absolutnej ścieżki do widoków
        $templatePath = __DIR__ . '/../../public/views/' . $template . '.php';
        $output = 'File not found';
    
        if (file_exists($templatePath)) {
            extract($variables); // Udostępnienie zmiennych widokowi
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }
}