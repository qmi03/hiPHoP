<section class="md:flex text-white">
  <div id="thumbnail-container" class="transition-all duration-1000 min-h-[500px] md:min-h-0 md:flex-3/4 bg-no-repeat bg-cover bg-center relative">
    <div class="absolute bottom-10">
      <h2 id="thumbnail-title" class="text-3xl bg-[#11111155] px-8 pt-8"></h2>
      <p id="thumbnail-summary" class="text-xl bg-[#11111155] px-8 pb-8"></p>
      <a id="thumbnail-button" class="shadow-black shadow-sm hidden bg-cyan-600 mx-8 px-4 py-2 text-lg font-bold my-6"></a>
    </div>
  </div>
  <div class="md:flex-1/4 flex flex-col gap-0">
    <?php foreach ($data['newsLetters'] as $index => $newsLetter) { ?>
      <?php if ($newsLetter->bgUrl) { ?>
        <link rel="preload" as="image" href="<?php echo htmlspecialchars($newsLetter->bgUrl); ?>">
      <?php } ?>
      <button
        id="newsletter-button-<?php echo $index; ?>"
        class="origin-right md:scale-x-100 transition-all translate-x-0 duration-500 h-24 cursor-pointer bg-pink-500 flex gap-2 items-center p-2 hover:bg-violet-600 hover:origin-left md:hover:scale-x-110"
        onclick='setNewsLetter(<?php echo $index; ?>)'>
        <svg id="newsletter-button-chevron-<?php echo $index; ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 rotate-0 transition-all duration-500">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="text-left text-lg"><?php echo htmlspecialchars($newsLetter->title); ?></span>
      </button>
    <?php } ?>
  </div>

  <script>
    const newsLetters = <?php echo json_encode($data['newsLetters']); ?>;
    const noOfNewsLetters = newsLetters.length;
    let curIndexOfNewsLetter = 0;
    setNewsLetter(curIndexOfNewsLetter);
    setInterval(() => {
      curIndexOfNewsLetter = (curIndexOfNewsLetter + 1) % noOfNewsLetters;
      setNewsLetter(curIndexOfNewsLetter);
    }, 8000);

    function setNewsLetter(index) {
      const currentNewsLetter = newsLetters[index];
      $("#thumbnail-container").css("background-image", `url(${currentNewsLetter.bgUrl})`);
      $("#thumbnail-title").text(currentNewsLetter.title);
      $("#thumbnail-summary").text(currentNewsLetter.summary);
      const thumbnailButton = $("#thumbnail-button");
      thumbnailButton.removeClass("hidden").removeClass("inline-block");
      if (currentNewsLetter.targetName) {
        thumbnailButton.addClass("inline-block");
        thumbnailButton.text(currentNewsLetter.targetName);
        thumbnailButton.attr("href", currentNewsLetter.targetUrl);
      } else {
        thumbnailButton.addClass("hidden");
      }

      for (let i = 0; i < noOfNewsLetters; ++i) {
        $(`#newsletter-button-${i}`).removeClass("bg-cyan-600")
          .addClass("bg-pink-500")
          .removeClass("shadow-black")
          .removeClass("shadow-sm")
          .addClass("translate-x-0")
          .addClass("md:scale-x-100")
          .removeClass("md:scale-x-110")
        $(`#newsletter-button-chevron-${i}`).removeClass("rotate-180")
          .addClass("rotate-0");
      }
      $(`#newsletter-button-${index}`).removeClass("bg-pink-500")
        .addClass("bg-cyan-600")
        .addClass("shadow-black")
        .addClass("shadow-sm")
        .removeClass("translate-x-0")
        .removeClass("md:scale-x-100")
        .addClass("md:scale-x-110")
      $(`#newsletter-button-chevron-${index}`).removeClass("rotate-0")
        .addClass("rotate-180");
    }
  </script>
</section>

<section class="mt-10 bg-white p-10 shadow-gray-300 shadow-sm">
  <h2 class="text-center text-3xl mb-10"><?php echo htmlspecialchars($data['introduction']->title); ?></h2>
  <?php foreach ($data['introduction']->paragraphs as $p) { ?>
    <p class="text-lg p-1"><?php echo htmlspecialchars($p); ?></p>
  <?php } ?>
</section>

<section class="mt-10 bg-white pb-10 shadow-gray-300 shadow-sm">
  <h2 class="text-center text-3xl mb-10 bg-pink-500 text-white p-5">OUR MOST POPULAR INSTRUMENTS</h2>
  <?php foreach ($data['instrument']->paragraphs as $p) { ?>
    <p class="text-lg p-1 px-10 "><?php echo htmlspecialchars($p); ?></p>
  <?php } ?>
  <div class="mt-10 px-10 flex md:justify-between justify-around gap-10 flex-wrap">
    <?php foreach ($data['instrument']->imageUrls as $url) { ?>
      <img width="200" src="<?php echo htmlspecialchars($url); ?>" alt="">
    <?php } ?>
  </div>
</section>

<div class="relative top-5 h-5 bg-cyan-500"></div>
<section class="relative top-5 min-h-[100px] z-50 bg-pink-500 text-white text-3xl p-5 shadow-gray-300 shadow-sm">
  <p class="text-center transition-all ease-in-out duration-1000">
    "<span id="quote-content"></span>"
    ~ <span id="quote-author"></span>
  </p>

  <script>
    const quotes = <?php echo json_encode($data['quote']); ?>;
    const noOfQuotes = quotes.length;
    setQuote(0);
    let quoteIndex = 0;
    setInterval(() => {
      quoteIndex = (quoteIndex + 1) % noOfQuotes;
      setQuote(quoteIndex);
    }, 3000);

    function setQuote(index) {
      const quote = quotes[index];
      $("#quote-content").text(quote.content);
      $("#quote-author").text(quote.author);
    }
  </script>
</section>
