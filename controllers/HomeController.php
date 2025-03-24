<?php

require_once 'views/index.php';

require_once 'models/home/NewsLetter.php';

require_once 'models/home/Introduction.php';

require_once 'models/home/PopularInstrument.php';

require_once 'models/home/Quote.php';

class HomeController
{
  public function route(string $method, string $path): void
  {
    if ('/' == $path && 'GET' == $method) {
      $this->index();
    }
  }

  public function index(): void
  {
    $newsLetters = new NewsLetterModel();
    $introduction = new IntroductionModel();
    $instrument = new PopularInstrumentModel();
    $quote = new QuoteModel();
    renderView('views/home/index.php', ['newsLetters' => $newsLetters->fetchAll(), 'introduction' => $introduction->fetch(), 'instrument' => $instrument->fetch(), 'quote' => $quote->fetchAll()]);
  }
}
