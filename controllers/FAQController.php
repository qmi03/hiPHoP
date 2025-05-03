<?php

require_once 'views/index.php';
require_once 'models/faq/FAQ.php';

class FAQController {
    public function route(string $method, string $path): void {
        if ('/faq/' == $path && 'GET' == $method) {
            $this->index();
        }
    }

    public function index(): void {
        $faqs = new FAQ();
        renderView('views/faq/index.php', [
            'faqs' => $faqs->fetchAll()
        ]);
    }
}
