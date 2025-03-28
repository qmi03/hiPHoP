<?php

require_once 'views/index.php';

function decodeDataUrl(string $dataUrl)
{
  if (0 !== strpos($dataUrl, 'data:')) {
    return false;
  }

  $parts = explode(',', $dataUrl, 2);
  if (2 !== count($parts)) {
    return false;
  }

  $mimeType = explode(';', $parts[0])[0];
  $mimeType = str_replace('data:', '', $mimeType);

  $imageData = base64_decode($parts[1]);

  return [
    'mime_type' => $mimeType,
    'data' => $imageData,
  ];
}

class LoginController
{
  public function route(string $method, string $path): void
  {
    if ('/login/' == $path) {
      if ('GET' == $method) {
        $this->index([]);
      } elseif ('POST' == $method) {
        $this->handleLoginForm($_POST);
      }
    } elseif ('/login/forgot-password/' == $path) {
      if ('GET' == $method) {
        $this->forgotPassword();
      } elseif ('POST' == $method) {
        $this->handleForgotPasswordForm($_POST);
      }
    } elseif ('/signup/' == $path) {
      if ('GET' == $method) {
        $this->signup([]);
      } elseif ('POST' == $method) {
        $this->handleSignupForm($_POST);
      }
    } elseif ('/logout/' == $path) {
      if ('GET' == $method) {
        $this->logout();
      }
    }
  }

  public function index(array $formData): void
  {
    if ($_SESSION['isLoggedIn']) {
      header('Location: /');

      exit;
    }
    renderView('views/login/index.php', $formData);
  }

  public function forgotPassword(): void
  {
    renderView('views/login/forgot-password.php', []);
  }

  public function signup(array $formData): void
  {
    renderView('views/login/signup.php', $formData);
  }

  public function handleLoginForm(array $formData): void
  {
    $email = trim($formData['email']);
    $password = trim($formData['password']);
    $rememberMe = 'on' == trim($formData['remember-me-checked']);

    if (!$email || preg_match_all('^[^@]+@[^@]+\\.[^@]+$', $email)) {
      $this->index(array_merge($formData, ['invalidField' => 'email']));

      return;
    }

    if (!$password || strlen($password) < 6 || strlen($password) > 256) {
      $this->index(array_merge($formData, ['invalidField' => 'password']));

      return;
    }

    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT password, id FROM users WHERE email = ?');
      $stmt->execute([$email]);
      $res = $stmt->fetch();
      if (!$res) {
        $this->index(array_merge($formData, ['authFailed' => true]));
        $conn->rollBack();

        exit;
      }
      $hash = $res['password'];
      if (!password_verify($password, $hash)) {
        $this->index(array_merge($formData, ['authFailed' => true]));
        $conn->rollBack();

        exit;
      }
      $conn->commit();
      $_SESSION['isLoggedIn'] = true;
      $_SESSION['id'] = $res['id'];
      if ($rememberMe) {
        $cookieLifetime = 60 * 60 * 24 * 30; // 30 days
        session_set_cookie_params($cookieLifetime);
      }
      header('Location: /');

      exit;
    } catch (PDOException $e) {
      $conn->rollBack();
      $this->index(array_merge($formData));
    }
  }

  public function handleSignupForm(array $formData): void
  {
    $username = trim($formData['username']);
    $password = trim($formData['password']);
    $rePassword = trim($formData['re-password']);
    $dob = trim($formData['dob']);
    $fname = trim($formData['firstname']);
    $lname = trim($formData['lastname']);
    $email = trim($formData['email']);
    $address = trim($formData['address']);
    $avatarDataUrl = trim($formData['avatarDataUrl']);

    if (!$username || strlen($username) <= 0) {
      $this->signup(array_merge($formData, ['invalidField' => 'username']));

      return;
    }

    if (!$password || strlen($password) < 6 || strlen($password) > 256) {
      $this->signup(array_merge($formData, ['invalidField' => 'password']));

      return;
    }

    if ($rePassword != $password) {
      $this->signup(array_merge($formData, ['invalidField' => 're-password']));

      return;
    }

    if (!$fname || strlen($fname) <= 0) {
      $this->signup(array_merge($formData, ['invalidField' => 'firstname']));

      return;
    }

    if (!$lname || strlen($lname) <= 0) {
      $this->signup(array_merge($formData, ['invalidField' => 'lastname']));

      return;
    }

    if (!$email || preg_match_all('^[^@]+@[^@]+\\.[^@]+$', $email)) {
      $this->signup(array_merge($formData, ['invalidField' => 'email']));

      return;
    }

    if (!$dob) {
      $this->signup(array_merge($formData, ['invalidField' => 'dob']));

      return;
    }
    if (date_parse($dob)['error_count'] > 0) {
      $this->signup(array_merge($formData, ['invalidField' => 'dob']));

      return;
    }

    $avatarUrl = '/public/assets/default-avatar.jpg';
    if ($avatarDataUrl && strlen($avatarDataUrl) > 0) {
      $res = decodeDataUrl($avatarDataUrl);
      if (!$res) {
        $this->signup(array_merge($formData, ['invalidField' => 'avatar']));

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

      $filename = 'avatar_'.time().'_'.mt_rand(1000, 9999).'.'.$extension;

      $filePath = $_SERVER['DOCUMENT_ROOT'].'/public/data/'.$filename;
      file_put_contents($filePath, $res['data']);

      $avatarUrl = '/public/data/'.$filename;
    }

    $password = password_hash($password, PASSWORD_BCRYPT);
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT username FROM users WHERE username = ?');
      $stmt->execute([$username]);
      $res = $stmt->fetch();
      if ($res) {
        $this->signup(array_merge($formData, ['invalidField' => 'username']));
        $conn->rollBack();

        exit;
      }
      $stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
      $stmt->execute([$email]);
      $res = $stmt->fetch();
      if ($res) {
        $this->signup(array_merge($formData, ['invalidField' => 'email']));
        $conn->rollBack();

        exit;
      }
      $stmt = $conn->prepare('INSERT INTO users (first_name, last_name, address, email, dob, username, password, avatar_url, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
      $stmt->execute([$fname, $lname, $address, $email, $dob, $username, $password, $avatarUrl, 0]);
      $conn->commit();
      header('Location: /login');

      exit;
    } catch (PDOException $e) {
      $conn->rollBack();
      $this->signup(array_merge($formData));
    }
  }

  public function logout(): void
  {
    unset($_SESSION['isLoggedIn'], $_SESSION['email']);

    session_destroy();
    header('Location: /');
  }

  public function handleForgotPasswordForm(array $formData): void
  {
    $email = $formData['email'];
    $subject = 'hiPHoP account recovery';
    $txt = 'This is your recovery PIN: ';
    $headers = 'From: hiPHoP@example.com';

    mail($email, $subject, $txt, $headers);

    renderView('views/login/forgot-password-sent.php', []);
  }
}
