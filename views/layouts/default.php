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
  <header>
    <div class="p-8 flex justify-between items-center">
      <a role="banner" href="/" class="font-black text-3xl tracking-widest grow-1">hiPHoP</a>
      <div class="flex items-center justify-between grow-6 lg:justify-end">
        <div class="flex gap-10">
          <button class="flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            <span>CART</span>
          </button>
          <button class="flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            <span>LOGIN</span>
          </button>
          <button>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
          </button>
        </div>
        <button onclick="$('#sidemenu').removeClass('translate-x-full')" class="lg:hidden font-extralight text-xl flex gap-1 items-center cursor-pointer">
          <span>MENU</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
    </div>
    <div>
      <nav class="hidden lg:flex justify-around bg-[#111] text-lg">
        <a class="border-black py-4 px-6 block <?= $path == "/" ? "text-black bg-white border-1" : "text-white" ?>" href="/">HOME</a>
        <a class="b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order-black py-4 px-6 block <?= $path == "/shop" ? "text-black bg-white border-1" : "text-white" ?>" href="/shop">SHOP</a>
        <a class="border-black py-4 px-6 block <?= $path == "/blog" ? "text-black bg-white border-1" : "text-white" ?>" href="/blog">BLOG</a>
        <a class="border-black py-4 px-6 block <?= $path == "/about" ? "text-black bg-white border-1" : "text-white" ?>" href="/about">ABOUT US</a>
        <a class="border-black py-4 px-6 block <?= $path == "/contac" ? "text-black bg-white border-1" : "text-white" ?>" href="/contact">CONTACT US</a>
        <a class="border-black py-4 px-6 block <?= $path == "/faq" ? "text-black bg-white border-1" : "text-white" ?>" href="/faq">FAQ</a>
      </nav>
      <nav id="sidemenu" class="translate-x-full transition-transform transition-duration-[2s] lg:hidden bg-[#111] fixed top-0 right-0 pl-18 pr-32 pt-28 h-[100vh]">
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
