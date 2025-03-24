<?php

require_once 'views/index.php';

require_once 'models/Contact.php';

class ContactController
{
  public function route(string $method, string $path): void
  {
    if ('/contact/' == $path && 'GET' == $method) {
      $this->index();
    }
  }

  public function index(): void
  {
    $contact = (new ContactModel())->fetch();
    renderView('views/contact/index.php', $contact);
  }
}
