<?php

require_once 'views/index.php';
require_once 'models/faq/FAQ.php';
require_once 'models/faq/UserQuestion.php';

class FAQController {
    public function route(string $method, string $path): void {
        if ('/faq' == $path || '/faq/' == $path) {
            if ('GET' == $method) {
                $this->index();
            } elseif ('POST' == $method) {
                $this->ask();
            }
        }
    }

    public function index(): void {
        error_log("FAQController::index started");
        
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
            $faqModel = new FAQModel();
            $faqs = $faqModel->fetchAll();
            
            error_log("FAQs fetched: " . print_r($faqs, true));
            
            $userQuestionModel = new UserQuestionModel();
            $userQuestions = [];
            $questionsCount = 0;
            $totalPages = 0;
            
            $isLoggedIn = isset($_SESSION['userId']);
            
            if ($isLoggedIn) {
                $userQuestions = $userQuestionModel->fetchByUserId($_SESSION['userId'], $page);
                $questionsCount = $userQuestionModel->countByUserId($_SESSION['userId']);
                $totalPages = ceil($questionsCount / 5);
            }

            // Sử dụng đường dẫn đầy đủ đến file view
            renderView('views/faq/index.php', [
                'user' => $GLOBALS['user'] ?? null,
                'faqs' => $faqs,
                'userQuestions' => $userQuestions ?? [],
                'questionsCount' => $questionsCount ?? 0,
                'currentPage' => $page,
                'totalPages' => $totalPages ?? 0,
                'isLoggedIn' => $isLoggedIn
            ]);
            
            error_log("View rendered successfully");
            
        } catch (Exception $e) {
            error_log("Error in FAQController::index - " . $e->getMessage());
            renderView('views/faq/index.php', [
                'error' => 'An error occurred while loading FAQs: ' . $e->getMessage(),
                'faqs' => []
            ]);
        }
    }

    public function ask(): void {
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
            return;
        }

        $question = $_POST['question'] ?? '';
        if (strlen($question) >= 10 && strlen($question) <= 1000) {
            $userQuestionModel = new UserQuestionModel();
            $userQuestionModel->create($_SESSION['userId'], $question);
        }
        
        header('Location: /faq');
    }
}
