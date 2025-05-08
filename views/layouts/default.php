<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>hiPHoP - Music ecommerce platform</title>
  <meta charset="UTF-8">
  <meta name="description" content="Music ecommerce platform">
  <meta name="keywords" content="Music, Ecommerce">
  <meta name="author" content="namdayneee, qmi03, Huy-DNA">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/tailwind.output.css">
  <link rel="stylesheet" href="/public/css/fonts.css">
  <link rel="icon" type="image/x-icon" href="/public/assets/logo_no_music_16.ico">
  <script src="/public/js/jquery.js"></script>
</head>

<?php
$path = $_SERVER['PATH'];
?>

<body class="min-h-[100vh] bg-[#eeeeee] relative pb-[500px] md:pb-[280px]">
  <div class="absolute z-[-1] top-0 left-0 w-[100vw]" role="none">
    <div class="h-40 bg-violet-900">
    </div>
    <div class="h-14 bg-linear-to-b from-violet-900 to-[#00000000]">
    </div>
  </div>
  <header class="xl:px-[calc(10vw+100px)] pl-[calc(3vw+170px)] min-h-20 bg-violet-900 relative">
    <a href="/" class="absolute z-50 top-0 left-[5vw] flex bg-cyan-600 p-3 gap-2 items-center shadow-gray-900 shadow-lg" role="button">
      <img class="w-14" src="/public/assets/logo_no_music.svg" alt="logo">
      <div class="flex flex-col font-sans font-bold gap-0 text-3xl">
        <span>hiP</span>
        <span>HoP</span>
      </div>
    </a>
    <button onclick="$('#sidemenu').removeClass('translate-x-full')" class="md:hidden cursor-pointer text-white flex gap-1 text-lg absolute top-10 right-4">
      <span>
        MENU
      </span>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
        <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
      </svg>
    </button>
    <nav id="sidemenu" class="translate-x-full transition-transform transition-duration-[2s] lg:hidden bg-violet-700 fixed top-0 right-0 pl-18 pr-32 pt-28 h-[100vh] z-60">
      <button onclick="$('#sidemenu').addClass('translate-x-full')" class="text-white absolute top-10 right-10 cursor-pointer transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </button>
      <?php if (!$_SESSION['isLoggedIn']) { ?>
        <a class="flex gap-2 items-center text-xl text-white <?php echo '/login/' == $path ? '' : 'opacity-80'; ?> m-4" href="/login">
          <span>LOGIN</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </a>
      <?php } else { ?>
        <div class="m-4 mb-8 text-lg">
          <a class="relative text-white text-xl font-bold items-center flex gap-2 <?php echo '/account/' == $path ? '' : 'opacity-90 hover:opacity-100 hover:italic'; ?> cursor-pointer" href="/account">
            <img width="30px" height="30px" alt="user avatar" src="<?php echo $GLOBALS['user']->avatarUrl; ?>" class="block w-[30px] h-[30px] rounded-full">
            <span><?php echo $GLOBALS['user']->username; ?></span>
          </a>
        </div>
        <?php if ($GLOBALS['user'] && $GLOBALS['user']->isAdmin): ?>
          <a class="flex gap-2 items-center text-xl text-white <?php echo '/logout/' == $path ? '' : 'opacity-80'; ?> m-4" href="/admin">
            <span>ADMIN</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
          </a>
        <?php endif; ?>
        <a class="flex gap-2 items-center text-xl text-white <?php echo '/logout/' == $path ? '' : 'opacity-80'; ?> m-4" href="/logout">
          <span>LOGOUT</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </a>
      <?php } ?>
      <a class="flex gap-2 items-center text-xl text-white <?php echo '/' == $path ? '' : 'opacity-80'; ?> m-4" href="/">
        <span>HOME</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl text-white <?php echo '/shop/' == $path ? '' : 'opacity-80'; ?> m-4" href="/shop">
        <span>SHOP</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl text-white <?php echo '/blog/' == $path ? '' : 'opacity-80'; ?> m-4" href="/blog">
        <span>BLOG</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl text-white <?php echo '/about/' == $path ? '' : 'opacity-80'; ?> m-4" href="/about">
        <span>ABOUT</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl text-white <?php echo '/contact/' == $path ? '' : 'opacity-80'; ?> m-4" href="/contact">
        <span>CONTACT</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl text-white <?php echo '/faq/' == $path ? '' : 'opacity-80'; ?> m-4" href="/contact">
        <span>FAQ</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
    </nav>
    <nav class="flex-wrap gap-6 p-5 pb-8 hidden md:flex">
      <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        <span class="<?php echo '/' == $path ? 'border-white border-b-1' : ''; ?>">HOME</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/about/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/about">
        <span class="<?php echo '/about/' == $path ? 'border-white border-b-1' : ''; ?>">ABOUT</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/shop/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/shop">
        <span class="<?php echo '/shop/' == $path ? 'border-white border-b-1' : ''; ?>">SHOP</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/blog/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/blog">
        <span class="<?php echo '/blog/' == $path ? 'border-white border-b-1' : ''; ?>">BLOG</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/contact/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/contact">
        <span class="<?php echo '/contact/' == $path ? 'border-white border-b-1' : ''; ?>">CONTACT</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/faq/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/faq">
        <span class="<?php echo '/faq/' == $path ? 'border-white border-b-1' : ''; ?>">FAQ</span>
      </a>
      <?php if (!$_SESSION['isLoggedIn']) { ?>
        <a class="text-white text-lg font-bold flex gap-2 items-center <?php echo '/login/' == $path ? '' : 'opacity-80 hover:opacity-100 hover:italic'; ?>" href="/login">
          <span class="<?php echo '/login/' == $path ? 'border-white border-b-1' : ''; ?>">LOGIN</span>
        </a>
      <?php } ?>
      <?php if ($_SESSION['isLoggedIn']) { ?>
        <div class="lg:ml-auto">
          <button class="relative text-white text-lg font-bold items-center flex gap-2 <?php echo '/account/' == $path ? '' : 'opacity-90 hover:opacity-100 hover:italic'; ?> group cursor-pointer">
            <img width="30px" height="30px" alt="user avatar" src="<?php echo $GLOBALS['user']->avatarUrl; ?>" class="block w-[30px] h-[30px] rounded-full">
            <span><?php echo $GLOBALS['user']->username; ?></span>
            <div role="menu" tabindex="-1" class="bg-pink-600 w-[200px] absolute group-hover:opacity-100 opacity-0 top-[35px] right-0 z-50 transition-all shadow-md shadow-gray-800 border-gray-800 border-1 flex flex-col items-stretch not-italic text-white">
              <?php if ($GLOBALS['user'] && $GLOBALS['user']->isAdmin): ?>
                <a class="p-1 hover:bg-cyan-600" href="/admin">Admin</a>
              <?php endif; ?>
              <a class="p-1 hover:bg-cyan-600" href="/account">Account</a>
              <a class="p-1 hover:bg-cyan-600" href="/logout">Logout</a>
            </div>
          </button>
        </div>
      <?php } ?>
    </nav>
  </header>
  <main class="xl:px-[8vw]">
    <div class="md:px-[2vw]">
      <?php echo $content; ?>
    </div>
  </main>
  <footer class="m-0 pb-16 bg-violet-900 p-10 px-[3vw] md:px-[5vw] w-[100vw] absolute bottom-0 text-white">
    <div class="flex flex-col md:flex-row gap-5 md:justify-between">
      <div class="flex flex-col md:flex-row gap-3 md:justify-between">
        <div>
          <img src="/public/assets/logo.svg" alt="logo" class="h-25">
        </div>
        <div class="text-lg">
          <p>Contact Us!</p>
          <p><?php echo htmlspecialchars($data['phone']); ?> (v)</p>
          <a href="mailto:<?php echo htmlspecialchars($data['email']); ?>" class="underline text-cyan-400"><?php echo htmlspecialchars($data['email']); ?></a>
        </div>
      </div>
      <div class="flex flex-row gap-5">
        <a href="<?php echo htmlspecialchars($data['facebook']); ?>" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" x="0px" y="0px" width="24" height="24" viewBox="0 0 50 50" class="fill-white">
            <path d="M40,0H10C4.486,0,0,4.486,0,10v30c0,5.514,4.486,10,10,10h30c5.514,0,10-4.486,10-10V10C50,4.486,45.514,0,40,0z M39,17h-3 c-2.145,0-3,0.504-3,2v3h6l-1,6h-5v20h-7V28h-3v-6h3v-3c0-4.677,1.581-8,7-8c2.902,0,6,1,6,1V17z"></path>
          </svg>
        </a>
        <a href="<?php echo htmlspecialchars($data['github']); ?>" target="_blank">
          <svg aria-hidden="true" height="24" version="1.1" viewBox="0 0 16 16" width="24" class="fill-white">
            <path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
          </svg>
        </a>
      </div>
    </div>
    <div class="mt-10 flex flex-col md:flex-row md:justify-between">
      <div class="flex flex-col md:flex-row md:justify-between">
        <p class="text-lg">© 2003 - <?php echo date('Y'); ?>, The hiPHoP, Inc.</p>
      </div>
      <div class="flex flex-row gap-4">
        <a class="font-bold text-lg opacity-80" href="/">Home</a>
        <span role="none" aria-hidden="true" class="opacity-80">•</span>
        <a class="cursor-pointer font-bold text-lg opacity-80" onclick="$('html, body').animate({ scrollTop:0 }, 'fast')">Top</a>
        <span role="none" aria-hidden="true" class="opacity-80">•</span>
        <?php if (!$_SESSION['isLoggedIn']) { ?>
          <a class="font-bold text-lg opacity-80" href="/login">Login</a>
        <?php } else { ?>
          <a class="font-bold text-lg opacity-80" href="/logout">Logout</a>
        <?php } ?>
        <span role="none" aria-hidden="true" class="opacity-80">•</span>
        <a class="font-bold text-lg opacity-80" href="/about">About</a>
      </div>
    </div>
  </footer>
</body>

</html>
