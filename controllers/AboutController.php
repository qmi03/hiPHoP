<?php

require_once 'views/index.php';
require_once 'models/about/About.php';

class AboutController {
    public function route(string $method, string $path): void {
        if ('/about/' == $path && 'GET' == $method) {
            $this->index();
        }
    }

    public function index(): void {
        $about = new About();
        renderView('views/about/index.php', [
            'aboutInfo' => $about->fetch(),
            'teamMembers' => $about->getTeamMembers()
        ]);
    }
}
