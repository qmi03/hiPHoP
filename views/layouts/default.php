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

<body>
  <div class="fixed z-[-1] top-0 left-0 w-[100vw]" role="none">
    <div class="h-30 bg-violet-900">
    </div>
    <div class="h-14 bg-linear-to-b from-violet-900 to-[#00000000]">
    </div>
  </div>
  <header class="px-[3vw] bg-violet-900">
    <a href="/" class="float-left flex bg-cyan-600 p-3 gap-2 items-center shadow-gray-900 shadow-lg" role="button">
      <img class="w-14" src="/public/assets/logo_no_music.svg" alt="logo">
      <div class="flex flex-col font-sans font-bold gap-0 text-3xl">
        <span>hiP</span>
        <span>HoP</span>
      </div>
    </a>
    <nav class="flex flex-wrap gap-10 p-5 pb-8">
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
  <main>
    <?php print $content ?>
  </main>
</body>

</html>
