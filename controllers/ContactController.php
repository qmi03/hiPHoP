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
    } else {
      renderView('views/404.php', []);
    }
  }


  public function index(): void
  {
    $contact = (new ContactModel())->fetch();
    renderView('views/contact/index.php', [
      'contact' => $contact
    ]);
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
}

