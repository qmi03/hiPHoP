<?php

require_once 'views/index.php';
require_once 'models/faq/FAQ.php';
require_once 'models/faq/UserQuestion.php';

class FAQController {
    public function route(string $method, string $path): void {
        if ('/faq' == $path || '/faq/' == $path) {
            $this->index($method);
            return;
        }

        if ($path === '/admin/faq' || $path === '/admin/faq/') {
            if ($method === 'GET') {
                $this->adminFaq();
            } elseif ($method === 'POST') {
                $this->adminFaqPost();
            }
            return;
        }
    }

    public function index(string $method = 'GET'): void {
        error_log("FAQController::index started");

        $sent = false;
        if ($method === 'POST') {
            if (!isset($_SESSION['userId'])) {
                header('Location: /login');
                exit;
            }
            $question = $_POST['question'] ?? '';
            if (strlen($question) >= 10 && strlen($question) <= 1000) {
                $userQuestionModel = new UserQuestionModel();
                $userQuestionModel->create($_SESSION['userId'], $question);
                header('Location: /faq?sent=1');
                exit;
            }
        } else {
            $sent = isset($_GET['sent']) ? true : false;
        }

        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
            $faqModel = new FAQModel();
            $faqs = $faqModel->fetchAll();

            $uniqueFaqs = [];
            $seenQuestions = [];
            foreach ($faqs as $faq) {
                if (!in_array($faq->question, $seenQuestions)) {
                    $uniqueFaqs[] = $faq;
                    $seenQuestions[] = $faq->question;
                }
            }

            $userQuestionModel = new UserQuestionModel();
            $userQuestions = [];
            $questionsCount = 0;
            $totalPages = 0;
            $paginatedQuestions = [];
            $isLoggedIn = isset($_SESSION['userId']);

            if ($isLoggedIn) {
                $userQuestions = $userQuestionModel->fetchByUserId($_SESSION['userId'], $page);
                $questionsCount = $userQuestionModel->countByUserId($_SESSION['userId']);
                $totalPages = ceil($questionsCount / 5);
                $paginatedQuestions = $userQuestions;
            }

            $startPage = max(0, $page - 2);
            $endPage = min($totalPages - 1, $page + 2);

            renderView('views/faq/index.php', [
                'user' => $GLOBALS['user'] ?? null,
                'faqs' => $uniqueFaqs,
                'userQuestions' => $userQuestions ?? [],
                'questionsCount' => $questionsCount ?? 0,
                'currentPage' => $page,
                'totalPages' => $totalPages ?? 0,
                'isLoggedIn' => $isLoggedIn,
                'sent' => $sent,
                'paginatedQuestions' => $paginatedQuestions,
                'startPage' => $startPage,
                'endPage' => $endPage
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

    public function adminFaq(): void {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            header('Location: /login');
            exit;
        }

        $message = $_SESSION['admin_message'] ?? null;
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_message'], $_SESSION['admin_error']);

        try {
            $faqModel = new FAQModel();
            $userQuestionModel = new UserQuestionModel();

            $faqs = $faqModel->fetchAll();
            $userQuestionsRaw = $userQuestionModel->fetchUnanswered();

            $userQuestions = [];
            $seenContents = [];
            foreach ($userQuestionsRaw as $question) {
                if (!in_array($question['content'], $seenContents)) {
                    $userQuestions[] = $question;
                    $seenContents[] = $question['content'];
                }
            }

            renderView('views/admin/faq.php', [
                'faqs' => $faqs,
                'userQuestions' => $userQuestions,
                'message' => $message,
                'error' => $error
            ]);
        } catch (Exception $e) {
            renderView('views/admin/faq.php', [
                'faqs' => [],
                'userQuestions' => [],
                'error' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    public function adminFaqPost(): void {
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            header('Location: /login');
            exit;
        }

        try {
            $faqModel = new FAQModel();
            $userQuestionModel = new UserQuestionModel();
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create':
                    $createData = $_POST['create'] ?? [];
                    if ($this->validateFaqData($createData)) {
                        if ($faqModel->create($createData)) {
                            $_SESSION['admin_message'] = 'New FAQ created successfully';
                        } else {
                            throw new Exception('Failed to create FAQ');
                        }
                    } else {
                        throw new Exception('Invalid FAQ data');
                    }
                    break;

                case 'update':
                    $updateId = $_POST['id'] ?? '';
                    $updateData = $_POST['update'] ?? [];
                    if ($updateId && $this->validateFaqData($updateData)) {
                        if ($faqModel->update([$updateId => $updateData])) {
                            $_SESSION['admin_message'] = 'FAQ updated successfully';
                        } else {
                            throw new Exception('Failed to update FAQ');
                        }
                    } else {
                        throw new Exception('Invalid FAQ data or ID');
                    }
                    break;

                case 'delete':
                    $deleteId = $_POST['id'] ?? '';
                    if ($deleteId) {
                        if ($faqModel->delete([$deleteId]) > 0) {
                            $_SESSION['admin_message'] = 'FAQ deleted successfully';
                        } else {
                            throw new Exception('Failed to delete FAQ');
                        }
                    } else {
                        throw new Exception('Invalid FAQ ID');
                    }
                    break;

                case 'answer_question':
                    $questionId = $_POST['answer_question']['id'] ?? '';
                    $answer = $_POST['answer_question']['answer'] ?? '';
                    if ($questionId && $answer) {
                        if ($userQuestionModel->markAsAnswered($questionId, $answer)) {
                            $question = $userQuestionModel->getById($questionId);
                            $faqModel->create([
                                'question' => $question['content'],
                                'answer' => $answer,
                                'category' => 'User Questions'
                            ]);
                            $_SESSION['admin_message'] = 'Question answered and added to FAQ successfully';
                        } else {
                            throw new Exception('Failed to process user question');
                        }
                    } else {
                        throw new Exception('Invalid question ID or answer');
                    }
                    break;

                default:
                    throw new Exception('Invalid action');
            }
        } catch (Exception $e) {
            $_SESSION['admin_error'] = $e->getMessage();
        }

        header('Location: /admin/faq');
        exit;
    }

    private function validateFaqData(array $data): bool {
        return isset($data['question']) 
            && isset($data['answer']) 
            && isset($data['category'])
            && strlen(trim($data['question'])) >= 5 
            && strlen(trim($data['question'])) <= 200
            && strlen(trim($data['answer'])) >= 10 
            && strlen(trim($data['category'])) >= 3;
    }
}