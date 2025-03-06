<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>hiPHop - Music ecommerce platform</title>
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
$path = $_SERVER["REQUEST_URI"];
?>

<body class="xl:px-[10vw] bg-[#eeeeee]">
  <div class="fixed z-[-1] top-0 left-0 w-[100vw]" role="none">
    <div class="h-40 bg-violet-900">
    </div>
    <div class="h-14 bg-linear-to-b from-violet-900 to-[#00000000]">
    </div>
  </div>
  <header class="pl-[calc(3vw+150px)] min-h-20 bg-violet-900 relative">
    <a href="/" class="absolute z-50 top-0 left-[3vw] flex bg-cyan-600 p-3 gap-2 items-center shadow-gray-900 shadow-lg" role="button">
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
    <nav id="sidemenu" class="translate-x-full transition-transform transition-duration-[2s] lg:hidden bg-cyan-700 fixed top-0 right-0 pl-18 pr-32 pt-28 h-[100vh] z-60">
      <button onclick="$('#sidemenu').addClass('translate-x-full')" class="text-white absolute top-10 right-10 cursor-pointer transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </button>
      <a class="flex gap-2 items-center text-xl <?= $path == "/" ? "text-white" : "text-gray-400" ?> m-4" href="/">
        <span>HOME</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl <?= $path == "/shop" ? "text-white" : "text-gray-400" ?> m-4" href="/shop">
        <span>SHOP</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl <?= $path == "/blog" ? "text-white" : "text-gray-400" ?> m-4" href="/blog">
        <span>BLOG</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl <?= $path == "/about" ? "text-white" : "text-gray-400" ?> m-4" href="/about">
        <span>ABOUT US</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
      <a class="flex gap-2 items-center text-xl <?= $path == "/contact" ? "text-white" : "text-gray-400" ?> m-4" href="/contact">
        <span>CONTACT US</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </a>
    </nav>
    <nav class="flex-wrap gap-6 p-5 pb-8 hidden md:flex">
      <a class="text-white text-lg font-bold flex gap-2 items-center <?= $path == "/" ? "" : "opacity-80  hover:opacity-100 hover:italic" ?>" href="/">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        <span class="<?= $path == "/" ? "border-white border-b-1" : "" ?>">HOME</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?= $path == "/about" ? "" : "opacity-80 hover:opacity-100 hover:italic" ?>" href="/about">
        <span class="<?= $path == "/about" ? "border-white border-b-1" : "" ?>">ABOUT</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?= $path == "/shop" ? "" : "opacity-80 hover:opacity-100 hover:italic" ?>" href="/shop">
        <span class="<?= $path == "/shop" ? "border-white border-b-1" : "" ?>">SHOP</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?= $path == "/blog" ? "" : "opacity-80 hover:opacity-100 hover:italic" ?>" href="/blog">
        <span class="<?= $path == "/blog" ? "border-white border-b-1" : "" ?>">BLOG</span>
      </a>
      <a class="text-white text-lg font-bold flex gap-2 items-center <?= $path == "/contact" ? "" : "opacity-80 hover:opacity-100 hover:italic" ?>" href="/contact">
        <span class="<?= $path == "/contact" ? "border-white border-b-1" : "" ?>">CONTACT</span>
      </a>
      <button class="text-white text-md font-bold flex gap-2 items-center opacity-80 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
      </button>
    </nav>
  </header>
  <main class="md:px-[2vw]">
    <?php print $content ?>
  </main>
</body>

</html>
