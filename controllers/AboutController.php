<?php

require_once 'views/index.php';
require_once 'models/about/About.php';

class AboutController {
    public function route(string $method, string $path): void {
        if ('/about' === $path || '/about/' === $path) {
            if ('GET' === $method) {
                $this->index();
            }
        } elseif ('/admin/about' === $path || '/admin/about/' === $path) {
            if ('POST' === $method) {
                $this->update();
            }
        }
    }

    public function index(): void {
        $aboutModel = new AboutModel();
        $about = $aboutModel->fetch();
        
        if (!$about) {
            error_log("Failed to fetch about data - check database connection and migrations");
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error loading page content. Please try again later.";
            exit;
        }
        
        renderView('views/about/index.php', [
            'user' => $GLOBALS['user'] ?? null,
            'about' => $about
        ]);
    }

    private function update(): void {
        if (!isset($GLOBALS['user']) || $GLOBALS['user']->role !== 'admin') {
            header('HTTP/1.1 403 Forbidden');
            exit('Access denied');
        }

        $id = $_POST['id'] ?? '';
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $currentImagePath = $_POST['current_image'] ?? '';
        
        // Remove leading slash from current image path
        $currentImagePath = ltrim($currentImagePath, '/');
        
        $updateData = [
            'title' => $title,
            'content' => $content,
            'current_image' => $currentImagePath
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $projectRoot = dirname(__DIR__);
            $uploadDir = $projectRoot . '/public/uploads/about/';
            
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newFileName = uniqid('about_', true) . '.' . $fileExtension;
            $uploadFile = $uploadDir . $newFileName;
            $newImagePath = 'uploads/about/' . $newFileName; // Remove leading slash

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                // Delete old image if exists and isn't default
                if (!empty($currentImagePath) && 
                    $currentImagePath !== 'uploads/about/default-about.jpg' && 
                    file_exists($projectRoot . '/public/' . $currentImagePath)) {
                    unlink($projectRoot . '/public/' . $currentImagePath);
                }
                
                $updateData['image_path'] = $newImagePath;
            } else {
                header('Location: /admin/about?error=1');
                exit;
            }
        }

        $aboutModel = new AboutModel();
        $success = $aboutModel->update($id, $updateData);

        header('Location: /admin/about?' . ($success ? 'success=1' : 'error=1'));
        exit;
    }
}
