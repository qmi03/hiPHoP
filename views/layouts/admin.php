<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Music ecommerce platform">
  <meta name="keywords" content="Music, Ecommerce">
  <meta name="author" content="namdayneee, qmi03, Huy-DNA">
  <title>hiPHoP - Admin Dashboard</title>
  <link rel="stylesheet" href="/public/css/fonts.css">
  <link rel="stylesheet" href="/public/css/tailwind.output.css">
  <link rel="stylesheet" href="/public/mazer/compiled/css/app.css">
  <link rel="stylesheet" href="/public/mazer/compiled/css/app-dark.css">
  <link rel="stylesheet" href="/public/mazer/compiled/css/iconly.css">
  <script src="/public/mazer/static/js/initTheme.js"></script>
</head>

<?php
$path = $_SERVER["PATH"];
$subpaths = explode("/", $path);
array_shift($subpaths);
array_shift($subpaths);
array_unshift($subpaths, "home");
array_pop($subpaths);
?>

<body>
  <div id="app">
    <div id="main" class="layout-horizontal">
      <header class="mb-5">
        <div class="header-top">
          <div class="container">
            <div class="logo flex gap-2 items-center">
              <a href="/admin/"><img src="/public/assets/logo_no_music.svg" alt="Logo"></a>
              <a href="/admin/">
                <p class="m-0 text-xl">hiPHoP</p>
              </a>
            </div>
            <div class="header-top-right">
              <div class="dropdown">
                <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="avatar avatar-md2">
                    <img src="/public/mazer/compiled/jpg/1.jpg" alt="Avatar">
                  </div>
                  <div class="text">
                    <h6 class="user-dropdown-name"><?= htmlspecialchars($data["user"]->username) ?></h6>
                    <p class="user-dropdown-status text-sm text-muted">Admin</p>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                  <li><a class="dropdown-item" href="#">My Account</a></li>
                  <li><a class="dropdown-item" href="#">Settings</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </div>
              <!-- Burger button responsive -->
              <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
              </a>
            </div>
          </div>
        </div>
        <nav class="main-navbar">
          <div class="container">
            <ul>
              <li
                class="menu-item active">
                <a href="/admin" class='menu-link'>
                  <span><i class="bi bi-house-door-fill"></i> Home</span>
                </a>
              </li>
              <li
                class="menu-item active">
                <a href="/admin/basic-info" class='menu-link'>
                  <span><i class="bi bi-file-earmark-medical-fill"></i> Basic info</span>
                </a>
              </li>
              <li
                class="menu-item active">
                <a href="/admin/contacts" class='menu-link'>
                  <span><i class="bi bi-bell-fill"></i> Contacts</span>
                </a>
              </li>
              <li
                class="menu-item has-sub">
                <a href="#" class='menu-link'>
                  <span><i class="bi bi-file-earmark-medical-fill"></i> Forms</span>
                </a>
                <div
                  class="submenu">
                  <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                  <div class="submenu-group-wrapper">
                    <ul class="submenu-group">
                      <li
                        class="submenu-item has-sub">
                        <a href="#"
                          class='submenu-link'>Form Elements</a>
                        <!-- 3 Level Submenu -->
                        <ul class="subsubmenu">
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Input</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Input Group</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Select</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Radio</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Checkbox</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Textarea</a>
                          </li>
                        </ul>
                      </li>
                      <li
                        class="submenu-item">
                        <a href="#"
                          class='submenu-link'>Form Layout</a>
                      </li>
                      <li
                        class="submenu-item has-sub">
                        <a href="#"
                          class='submenu-link'>Form Validation</a>
                        <!-- 3 Level Submenu -->
                        <ul class="subsubmenu">
                          <li class="subsubmenu-item ">
                            <a href="#" class="subsubmenu-link">Parsley</a>
                          </li>
                        </ul>
                      </li>
                      <li
                        class="submenu-item has-sub">
                        <a href="#"
                          class='submenu-link'>Form Editor</a>
                        <!-- 3 Level Submenu -->
                        <ul class="subsubmenu">
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Quill</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">CKEditor</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">Summernote</a>
                          </li>
                          <li class="subsubmenu-item">
                            <a href="#" class="subsubmenu-link">TinyMCE</a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <div class="content-wrapper container">
        <div class="mb-5">
          <div aria-label="breadcrumb">
            <ol class="breadcrumb">
              <?php foreach ($subpaths as $subpath): ?>
                <li class="breadcrumb-item text-black" aria-current="page">
                  <a href="/admin/<?= $subpath == "home" ? "" : $subpath ?>"><?= htmlspecialchars(ucwords(join(" ", explode("-", $subpath)))) ?>
                  </a>
                </li>
              <?php endforeach ?>
            </ol>
          </div>
        </div>
        <?php print $content ?>
      </div>
      <footer>
        <div class="container">
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <p>2025 &copy; hiPHoP</p>
            </div>
            <div class="float-end">
              <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                  href="https://saugi.me">Huy-DNA</a></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
</body>

<script src="public/mazer/static/js/components/dark.js"></script>
<script src="public/mazer/static/js/pages/horizontal-layout.js"></script>
<script src="public/mazer/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="public/mazer/compiled/js/app.js"></script>
<script src="public/mazer/extensions/apexcharts/apexcharts.min.js"></script>
<script src="public/mazer/static/js/pages/dashboard.js"></script>

</html>
