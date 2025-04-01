<?php

require_once 'views/index.php';

class AccountController
{
  public function route(string $method, string $path): void
  {
    if ('/account/' == $path) {
      if ($_REQUEST['update'] && 'POST' == $method) {
        $this->handleAccountUpdateForm($_POST);
      } elseif ('GET' == $method) {
        $this->index([]);
      }
    }
  }

  public function handleAccountUpdateForm(array $formData): void
  {
    $oldPassword = trim($formData['old-password']);
    $password = trim($formData['new-password']);
    $rePassword = trim($formData['re-password']);
    $dob = trim($formData['dob']);
    unset($formData['dob']);
    $fname = trim($formData['firstname']);
    $lname = trim($formData['lastname']);
    $address = trim($formData['address']);
    $avatarDataUrl = trim($formData['avatarDataUrl']);
    $email = $GLOBALS["user"]->email;

    if (strlen($oldPassword) > 0 && (strlen($oldPassword) < 6 || strlen($oldPassword) > 256)) {
      $this->index(array_merge($formData, ['invalidField' => 'old-password']));

      return;
    }

    if (strlen($password) > 0 && (strlen($password) < 6 || strlen($password) > 256)) {
      $this->index(array_merge($formData, ['invalidField' => 'new-password']));

      return;
    }

    if (strlen($password) > 0 && $rePassword != $password) {
      $this->index(array_merge($formData, ['invalidField' => 're-password']));

      return;
    }

    if (strlen($password) > 0 || strlen($oldPassword) > 0) {
      $conn = Database::getInstance();

      try {
        $conn->beginTransaction();
        $stmt = $conn->prepare('SELECT password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $res = $stmt->fetch();
        $hash = $res['password'];
        if (!password_verify($oldPassword, $hash)) {
          $this->index(array_merge($formData, ['invalidField' => 'old-password']));
          $conn->rollBack();

          exit;
        }
        $conn->commit();
      } catch (PDOException $e) {
        $conn->rollBack();
        $this->index(array_merge($formData, ['invalidField' => 'old-password']));
        exit;
      }
    }


    if (!$fname || strlen($fname) <= 0) {
      $this->index(array_merge($formData, ['invalidField' => 'firstname']));

      return;
    }

    if (!$lname || strlen($lname) <= 0) {
      $this->index(array_merge($formData, ['invalidField' => 'lastname']));

      return;
    }

    if (!$dob) {
      $this->index(array_merge($formData, ['invalidField' => 'dob']));

      return;
    }
    if (date_parse($dob)['error_count'] > 0) {
      $this->index(array_merge($formData, ['invalidField' => 'dob']));

      return;
    }

    $avatarUrl = $GLOBALS['user']->avatarUrl;
    if ($avatarDataUrl && strlen($avatarDataUrl) > 0) {
      $res = decodeDataUrl($avatarDataUrl);
      if (!$res) {
        $this->index(array_merge($formData, ['invalidField' => 'avatar']));

        return;
      }

      $mimeExtensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'image/bmp' => 'bmp',
        'image/svg+xml' => 'svg',
      ];

      $extension = isset($mimeExtensions[$res['mime_type']])
        ? $mimeExtensions[$res['mime_type']]
        : 'jpg';

      $filename = 'avatar_' . time() . '_' . mt_rand(1000, 9999) . '.' . $extension;

      $filePath = $_SERVER['DOCUMENT_ROOT'] . '/public/data/' . $filename;
      file_put_contents($filePath, $res['data']);

      $avatarUrl = '/public/data/' . $filename;
    }

    if ($password) {
      $password = password_hash($password, PASSWORD_BCRYPT);
    }
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      if ($password) {
        $stmt = $conn->prepare('
        UPDATE users
        SET first_name = ?,
            last_name = ?,
            address = ?,
            dob = ?,
            password = ?,
            avatar_url = ?
        WHERE id = ?');
        $stmt->execute([$fname, $lname, $address, $dob, $password, $avatarUrl, $GLOBALS['user']->id]);
      } else {
        $stmt = $conn->prepare('
        UPDATE users
        SET first_name = ?,
            last_name = ?,
            address = ?,
            dob = ?,
            avatar_url = ?
        WHERE id = ?');
        $stmt->execute([$fname, $lname, $address, $dob, $avatarUrl, $GLOBALS['user']->id]);
      }
      $conn->commit();
      header('Location: /account');

      exit;
    } catch (PDOException $e) {
      $conn->rollBack();
      $this->index([]);
    }
  }

  public function index(array $formData): void
  {
    $user = $GLOBALS['user'];
    renderView('views/account/index.php', array_merge([
      'username' => $user->username,
      'firstname' => $user->firstName,
      'lastname' => $user->lastName,
      'email' => $user->email,
      'dob' => $user->dob,
      'address' => $user->address,
      'avatarUrl' => $user->avatarUrl,
    ], $formData));
  }
}
