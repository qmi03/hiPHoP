<?php
require_once("views/index.php");
require_once("models/NewsLetter.php");

class HomeController
{
  public function index(): void
  {
    $newsLetters = new NewsLetterModel();
    renderView("views/home/index.php", array("newsLetters" => $newsLetters->fetchAll()));
  }
}
