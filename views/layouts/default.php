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
  <script src="/public/js/jquery.js"></script>
</head>

<?php
$path = $_SERVER["REQUEST_URI"];
?>

<body>
  <header class="p-8 flex justify-between items-center">
    <a role="banner" href="/" class="font-black text-3xl tracking-widest">hiPHoP</a>
    <div>
      <button onclick="$('#sidemenu').removeClass('translate-x-full')" class="lg-hidden font-extralight text-xl flex gap-1 items-center cursor-pointer">
        <span>MENU</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
      <nav id="sidemenu" class="translate-x-full transition-transform transition-duration-[2s] lg-hidden bg-[#111] fixed top-0 right-0 pl-18 pr-32 pt-28 h-[100vh]">
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
        <a class="flex gap-2 items-center text-xl <?= $path == "/faq" ? "text-white" : "text-gray-400" ?> m-4" href="/faq">
          <span>FAQ</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m7.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </a>
      </nav>
    </div>
  </header>
  <main>
    <?php print $content ?>
  </main>
</body>

</html>
