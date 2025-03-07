<?php
require_once("views/index.php");
require_once("models/Contact.php");

class ContactController
{
  public function index(): void
  {
    $contact = (new ContactModel())->fetch();
    renderView("views/contact/index.php", $contact);
  }
}
