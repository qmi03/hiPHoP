<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Have questions or need support? We're here to help!</h1>
</section>

<section class="bg-white mx-5 lg:mx-20 relative top-[-10px] text-lg md:flex items-center justify-between gap-5">
  <p class="flex-1/3 text-white bg-cyan-600 self-stretch p-10 text-xl font-bold text-center flex items-center justify-center">Our contact info</p>
  <ul class="flex-2/3 px-5 py-5 list-none md:mt-5 text-2xl">
    <li class="flex gap-2 underline text-cyan-600"><span>📧</span><a href="mailto:<?= $data["email"] ?>"><?= $data["email"] ?></a></li>
    <li class="mt-3 flex gap-2"><span>📞</span><a href="tel:<?= $data["phone"] ?>" class="underline text-cyan-600"><?= $data["phone"] ?></a></li>
    <li class="mt-3 flex gap-2"><span>📍</span><a href="#map" class="underline text-cyan-600"><?= $data["address"] ?></a></li>
  </ul>
</section>

<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  You can also fill out our contact form, and we’ll get back to you as soon as possible!

  <form method="post" action="">
  </form>
</section>

<section class="mt-10 bg-white mx-5 lg:mx-20 relative">
  <h2 class="p-5 text-xl text-white text-center bg-pink-500">Find Us on the Map</h2>
  <div id="map">
  </div>
</section>
