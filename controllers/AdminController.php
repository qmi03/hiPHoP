<?php

require_once 'views/index.php';

require_once 'models/Photo.php';
require_once 'models/home/NewsLetter.php';

class AdminController
{
  public function route(string $method, string $path): void
  {
    if (!$GLOBALS['user']->isAdmin) {
      renderView('views/404.php', []);
      exit();
    }
    if ('/admin/' == $path) {
      if ('GET' == $method) {
        if ($_REQUEST['photo-query']) {
          $this->searchPhoto(['name' => $_REQUEST['photo-query']]);
        } else {
          $this->index([]);
        }
      } elseif ('POST' == $method) {
        if (array_key_exists('upload-photo', $_REQUEST)) {
          $this->uploadPhoto(array_merge($_POST, $_FILES));
        } elseif (array_key_exists('delete-photo', $_REQUEST)) {
          $this->deletePhoto(['id' => $_REQUEST['delete-photo']]);
        } elseif ($_REQUEST['contact-update']) {
          $this->handleContactUpdate($_POST);
        }
      }
    } elseif ('/admin/home-page/' == $path) {
      if ('GET' == $method) {
        $this->homePage();
      } elseif ('POST' == $method && $_REQUEST['introduction-update']) {
        $this->handleIntroductionUpdate($_POST);
      } elseif ('POST' == $method && $_REQUEST['quote-update']) {
        $this->handleQuoteUpdate(json_decode(file_get_contents("php://input"), true));
      } elseif ('POST' == $method && $_REQUEST['newsletter-update']) {
        $this->handleNewsLetterUpdate($_POST);
      }
    } elseif ('/admin/contacts/' == $path) {
      if ('GET' == $method) {
        $this->contacts();
      }
    } elseif ('/admin/users/' == $path) {
      if ('GET' == $method) {
        $this->users();
      }
    }
  }

  public function index(array $data): void
  {
    $galleryPage = (int) $_GET['gallery-page'] + 0;
    $photoModel = new PhotoModel();
    $photoCount = $photoModel->fetchCount();
    $contact = new ContactModel();
    renderAdminView('views/admin/index.php', array_merge(['user' => $GLOBALS['user'], 'photoCount' => $photoModel->fetchCount(), 'photos' => $photoModel->fetchPage((int) $galleryPage, 12), 'currentPhotoPage' => $galleryPage, 'totalPhotoPages' => (int) ($photoCount / 12), "contact" => $contact->fetch()], $data));
  }

  public function contacts(): void
  {
    renderAdminView('views/admin/contacts.php', ['user' => $GLOBALS['user']]);
  }

  public function users(): void
  {
    $userQuery = $_GET['query'] ?? '';
    $userPage = (int) $_GET['page'] + 0;

    $userModel = new UserModel();
    $paginatedUsers = $userQuery === ''
      ? $userModel->fetchPage($userPage, 12)
      : $userModel->fetchPageByKeyword($userQuery, $userPage, 12);
    $usersCount = $userQuery === ''
      ? $userModel->fetchCount()
      : $userModel->fetchCountByKeyword($userQuery);

    renderAdminView('views/admin/users.php', [
      'user' => $GLOBALS['user'],
      'paginatedUsers' => $paginatedUsers,
      'query' => $userQuery,
      'usersCount' => $usersCount,
      'currentPage' => $userPage,
      'totalPages' => (int) ($usersCount / 12),
    ]);
  }

  public function handleQuoteUpdate(array $formData): void
  {
    $quoteModel = new QuoteModel();
    $quoteModel->update(array_filter($formData["changed"], function ($change) {
      return strlen($change["author"]) > 0 && strlen($change["content"]) > 0;
    }));
    $quoteModel->delete($formData["deleted"]);
    $quoteModel->create(array_filter($formData["created"], function ($created) {
      return strlen($created["author"]) > 0 && strlen($created["content"]) > 0;
    }));
  }

  public function handleNewsLetterUpdate(array $formData): void
  {
    $newsLetterModel = new NewsLetterModel();
    if ($formData["changed"]) {
      $newsLetterModel->update(array_filter($formData["changed"], function ($change) {
        return strlen($change["title"]) > 0 && strlen($change["summary"]) > 0 && strlen($change["bgUrl"]) > 0;
      }));
    }
    if ($formData["deleted"]) {
      $newsLetterModel->delete($formData["deleted"]);
    }
    if ($formData["created"]) {
      $newsLetterModel->create(array_filter($formData["created"], function ($created) {
        return strlen($created["title"]) > 0 && strlen($created["summary"]) > 0 && strlen($created["bgUrl"]) > 0;
      }));
    }
  }

  public function handleIntroductionUpdate(array $formData): void
  {
    $title = trim($formData['title']);
    $paragraphs = trim($formData['paragraphs']);

    if (!$title || strlen($title) <= 0) {
      $this->homePage(array_merge($formData, ['invalidField' => 'introduction-title']));

      return;
    }

    if (!$paragraphs || strlen($paragraphs) <= 0) {
      $this->homePage(array_merge($formData, ['invalidField' => 'introduction-paragraphs']));

      return;
    }

    $introduction = new IntroductionModel();
    $introduction->update($title, explode("\n", $paragraphs));
    header('Location: /admin/home-page');
  }

  public function handleContactUpdate(array $formData): void
  {
    $address = trim($formData['address']);
    $phone = trim($formData['phone']);
    $longitude = trim($formData['longitude']);
    $latitude = trim($formData['latitude']);
    $facebook = trim($formData['facebook']);
    $github = trim($formData['github']);
    $email = trim($formData['email']);

    if (!$address || strlen($address) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-address']));

      return;
    }

    if (!$phone || strlen($phone) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-phone']));

      return;
    }

    if (!$facebook || strlen($facebook) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-facebook']));

      return;
    }

    if (!$github || strlen($github) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-github']));

      return;
    }

    if (!$longitude || strlen($longitude) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-longitude']));

      return;
    }

    if (!$latitude || strlen($latitude) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-latitude']));

      return;
    }

    if (!$email || strlen($email) <= 0) {
      $this->contacts(array_merge($formData, ['invalidField' => 'contact-email']));

      return;
    }

    $contact = new ContactModel();
    $contact->update($address, $phone, $email, $facebook, $github, $latitude, $longitude);
    header('Location: /admin');
  }

  public function homePage(): void
  {
    $newsLetters = new NewsLetterModel();
    $introduction = new IntroductionModel();
    $quote = new QuoteModel();

    renderAdminView('views/admin/home-page.php', ['user' => $GLOBALS['user'], 'newsLetters' => $newsLetters->fetchAll(), 'introduction' => $introduction->fetch(), 'quote' => $quote->fetchAll()]);
  }

  public function uploadPhoto(array $formData): void
  {
    if (!$formData['name'] || strlen($formData['name']) <= 0) {
      $this->index(array_merge($formData, ['invalidPhotoField' => 'name']));

      exit;
    }

    if (!$formData['filepond'] || !$formData['filepond']['tmp_name']) {
      $this->index(array_merge($formData, ['invalidPhotoField' => 'filepond']));

      exit;
    }

    rename($formData['filepond']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/public/data/' . basename($formData['filepond']['tmp_name']) . '_' . $formData['name'] . '_' . $formData['filepond']['name']);

    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('INSERT INTO photos(name, url) VALUES (?, ?)');
      $stmt->execute([$formData['name'], '/public/data/' . basename($formData['filepond']['tmp_name']) . '_' . $formData['name'] . '_' . $formData['filepond']['name']]);
      $conn->commit();
    } catch (PDOException $e) {
      $conn->rollBack();
      echo '<script>Unknown database error</script>';
    }

    header('Location: /admin');
  }

  public function searchPhoto(array $formData): void
  {
    $galleryPage = (int) $_GET['gallery-page'] + 0;
    if (!$formData['name'] || strlen($formData['name']) <= 0) {
      $this->index([]);

      exit;
    }
    $photoModel = new PhotoModel();
    $photoCount = $photoModel->fetchCountByKeyword($formData['name']);
    renderAdminView('views/admin/index.php', ['user' => $GLOBALS['user'], 'photoCount' => $photoCount, 'photos' => $photoModel->fetchPageByKeyword($formData['name'], (int) $galleryPage, 12), 'currentPhotoPage' => $galleryPage, 'totalPhotoPages' => (int) ($photoCount / 12)]);
  }

  public function deletePhoto(array $formData): void
  {
    if (!$formData['id'] || strlen($formData['id']) <= 0) {
      $this->index([]);

      exit;
    }

    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('DELETE FROM photos WHERE id = ?');
      $stmt->execute([$formData['id']]);
      $conn->commit();
    } catch (PDOException $e) {
      $conn->rollBack();
      echo '<script>Unknown database error</script>';
    }

    header('Location: /admin');
  }
}
