<?php
require_once("views/index.php");
require_once("models/Photo.php");

class AdminController
{
  public function route(string $method, string $path): void
  {
    if ($path == "/admin/") {
      if ($method == "GET") {
        if ($_REQUEST["photo-query"]) {
          $this->searchPhoto(["name" => $_REQUEST["photo-query"]]);
        } else {
          $this->index([]);
        }
      } else if ($method == "POST") {
        if (array_key_exists("upload-photo", $_REQUEST)) {
          $this->uploadPhoto(array_merge($_POST, $_FILES));
        } else if (array_key_exists("delete-photo", $_REQUEST)) {
          $this->deletePhoto(["id" => $_REQUEST["delete-photo"]]);
        }
      }
    } else if ($path == "/admin/home-page/" && $method = "GET") {
      $this->homePage();
    } else if ($path == "/admin/contacts/" && $method == "GET") {
      $this->contacts();
    }
  }

  public function index(array $data): void
  {
    $galleryPage = (int)$_GET["gallery-page"] + 0;
    $photoModel = new PhotoModel();
    $photoCount = $photoModel->fetchCount();
    renderAdminView("views/admin/index.php", array_merge(array("user" => $GLOBALS["user"], "photoCount" => $photoModel->fetchCount(), "photos" => $photoModel->fetchPage((int)$galleryPage, 12), "currentPhotoPage" => $galleryPage, "totalPhotoPages" => (int)($photoCount / 12)), $data));
  }

  public function contacts(): void
  {
    renderAdminView("views/admin/contacts.php", array("user" => $GLOBALS["user"]));
  }

  public function homePage(): void
  {
    $newsLetters = new NewsLetterModel();
    $introduction = new IntroductionModel();
    $instrument = new PopularInstrumentModel();
    $quote = new QuoteModel();

    renderAdminView("views/admin/home-page.php", array("user" => $GLOBALS["user"], "newsLetters" => $newsLetters->fetchAll(), "introduction" => $introduction, "instrument" => $instrument->fetch(), "quote" => $quote->fetchAll()));
  }

  public function uploadPhoto(array $formData): void
  {
    if (!$formData["name"] || strlen($formData["name"]) <= 0) {
      $this->index(array_merge($formData, ["invalidPhotoField" => "name"]));
      exit();
    }

    if (!$formData["filepond"] || !$formData["filepond"]["tmp_name"]) {
      $this->index(array_merge($formData, ["invalidPhotoField" => "filepond"]));
      exit();
    }

    rename($formData["filepond"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/public/data/" . basename($formData["filepond"]["tmp_name"]) . "_" . $formData["name"] . "_" . $formData["filepond"]["name"]);

    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare("INSERT INTO photos(name, url) VALUES (?, ?)");
      $stmt->execute([$formData["name"], "/public/data/" . basename($formData["filepond"]["tmp_name"]) . "_" . $formData["name"] . "_" . $formData["filepond"]["name"]]);
      $conn->commit();
    } catch (PDOException $e) {
      $conn->rollBack();
      echo "<script>Unknown database error</script>";
    }

    header("Location: /admin");
  }

  public function searchPhoto(array $formData): void
  {
    $galleryPage = (int)$_GET["gallery-page"] + 0;
    if (!$formData["name"] || strlen($formData["name"]) <= 0) {
      $this->index(array());
      exit();
    }
    $photoModel = new PhotoModel();
    $photoCount = $photoModel->fetchCountByKeyword($formData["name"]);
    renderAdminView("views/admin/index.php", array("user" => $GLOBALS["user"], "photoCount" => $photoCount, "photos" => $photoModel->fetchPageByKeyword($formData["name"], (int)$galleryPage, 12), "currentPhotoPage" => $galleryPage, "totalPhotoPages" => (int)($photoCount / 12)));
  }

  public function deletePhoto(array $formData): void
  {
    if (!$formData["id"] || strlen($formData["id"]) <= 0) {
      $this->index([]);
      exit();
    }

    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
      $stmt->execute([$formData["id"]]);
      $conn->commit();
    } catch (PDOException $e) {
      $conn->rollBack();
      echo "<script>Unknown database error</script>";
    }

    header("Location: /admin");
  }
}
