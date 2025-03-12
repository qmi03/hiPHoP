<?php
require_once("views/index.php");
require_once("models/Photo.php");

class AdminController
{
  public function route(string $method, string $path): void
  {
    if ($path == "/admin/" && $method == "GET") {
      $this->index([]);
    } else if ($path == "/admin/basic-info/" && $method = "GET") {
      $this->info();
    } else if ($path == "/admin/contacts/" && $method == "GET") {
      $this->contacts();
    } else if ($path == "/admin/photo/upload/") {
      if ($method == "POST") {
        $this->uploadPhoto(array_merge($_POST, $_FILES));
      } else if ($method == "GET") {
        header("Location: /admin");
      }
    }
  }

  public function index(array $data): void
  {
    $galleryPage = (int)$_GET["gallery-page"] + 0;
    $photoModel = new PhotoModel();
    renderAdminView("views/admin/index.php", array_merge(array("user" => $GLOBALS["user"], "photoCount" => $photoModel->fetchCount(), "photos" => $photoModel->fetchPage((int)$galleryPage, 24), "currentPhotoPage" => $galleryPage, "totalPhotoPages" => (int)($galleryPage / 24)), $data));
  }

  public function contacts(): void
  {
    renderAdminView("views/admin/contacts.php", array("user" => $GLOBALS["user"]));
  }

  public function info(): void
  {
    $newsLetters = new NewsLetterModel();
    $introduction = new IntroductionModel();
    $instrument = new PopularInstrumentModel();
    $quote = new QuoteModel();

    renderAdminView("views/admin/basic-info.php", array("user" => $GLOBALS["user"], "newsLetters" => $newsLetters->fetchAll(), "introduction" => $introduction, "instrument" => $instrument->fetch(), "quote" => $quote->fetchAll()));
  }

  public function uploadPhoto(array $formData): void
  {
    if (!$formData["name"] || strlen($formData["name"]) <= 0) {
      $this->index(array_merge($formData, ["invalidPhotoField" => "name"]));
      header('Location: /');
      exit();
    }

    if (!$formData["filepond"] || !$formData["filepond"]["tmp_name"]) {
      $this->index(array_merge($formData, ["invalidPhotoField" => "filepond"]));
      exit();
    }
  }
}
