<?php

require_once 'config/index.php';

require_once 'models/User.php';

if ($_SESSION['isLoggedIn']) {
  $id = $_SESSION['id'];
  $GLOBALS['user'] = (new UserModel())->fetchById($id);
}
