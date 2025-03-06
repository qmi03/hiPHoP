<?php
require_once("views/index.php");
require_once("models/NewsLetter.php");
require_once("models/Introduction.php");
require_once("models/PopularInstrument.php");
require_once("models/Quote.php");

class HomeController
{
  public function index(): void
  {
    $newsLetters = new NewsLetterModel();
    $introduction = new IntroductionModel();
    $instrument = new PopularInstrumentModel();
    $quote = new QuoteModel();
    renderView("views/home/index.php", array("newsLetters" => $newsLetters->fetchAll(), "introduction" => $introduction->fetch(), "instrument" => $instrument->fetch(), "quote" => $quote->fetchAll()));
  }
}
