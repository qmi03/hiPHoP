<?php

class Quote
{
  public string $content;
  public string $author;

  public function __construct(string $content, string $author)
  {
    $this->content = $content;
    $this->author = $author;
  }
}

class QuoteModel
{
  public function fetchAll(): array
  {
    return [
      new Quote("Your instruments aspire me to be a great musician", "Huy-DNA"),
      new Quote("You are the best teachers that I have ever met!", "Jill Jay"),
      new Quote("I was very surprised by the thoroughness of your courses", "Rose Mallet"),
    ];
  }
}
