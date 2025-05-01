<?php

require_once 'views/index.php';

require_once 'models/Contact.php';

require_once 'models/ContactMessage.php';

class ContactController
{
  public function route(string $method, string $path): void
  {
    if ('/contact/' == $path && 'GET' == $method) {
      $this->index();
    } else if ('/contact/' == $path && 'POST' == $method && $_SESSION['isLoggedIn']) {
      $this->handleContactForm($_POST);
    } else if ('/contact/messages/' == $path && 'GET' == $method) {
      $this->viewMessage($_GET['id'] ?? 0);
    } else {
      renderView('views/404.php', []);
    }
  }


  public function index(): void
  {
    $contact = (new ContactModel())->fetch();

    $data = [
      'contact' => $contact
    ];

    if ($_SESSION['isLoggedIn']) {
      $contactMessageModel = new ContactMessageModel();

      $page = max((int) $_GET['page'] + 0, 0);

      $paginatedMessages = $contactMessageModel->fetchPageByUserId($_SESSION['id'], $page, 6);
      $messagesCount = $contactMessageModel->countByUserId($_SESSION['id']);
      $totalPages = ceil($messagesCount / 6);
      $startPage = min(max($totalPages - 1 - 3, 0), $page);
      $endPage = min($startPage + 3, $totalPages - 1);

      $data['paginatedMessages'] = $paginatedMessages;
      $data['messagesCount'] = $messagesCount;
      $data['currentPage'] = $page;
      $data['startPage'] = $startPage;
      $data['endPage'] = $endPage;
      $data['totalPages'] = $totalPages;
    }

    renderView('views/contact/index.php', $data);
  }

  public function handleContactForm(array $data): void
  {
    if ($_SESSION['isLoggedIn']) {
      $contactMessageModel = new ContactMessageModel();
      $contactMessageModel->create(
        userId: $_SESSION['id'],
        title: $data['title'],
        message: $data['message'],
      );
    }
    header('Location: /contact');
    exit();
  }

  public function viewMessage(int $id): void
  {
    print_r($id);
    if (!$_SESSION['isLoggedIn']) {
      renderView('views/404.php', []);
      return;
    }
    $contactMessageModel = new ContactMessageModel();
    $message = $contactMessageModel->fetchById($id);
    if ($message == null || $message->userId != $_SESSION['id']) {
      renderView('views/404.php', []);
      return;
    }

    renderView('views/contact/view-message.php', [
      'message' => $message
    ]);
  }
}

