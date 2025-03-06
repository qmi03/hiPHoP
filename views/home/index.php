<section class="md:flex text-white">
  <div id="thumbnail-container" class="transition-all duration-1000 min-h-[500px] md:min-h-0 md:flex-3/4 bg-no-repeat bg-cover bg-center relative">
    <div class="absolute bottom-10">
      <h2 id="thumbnail-title" class="text-3xl bg-[#11111155] px-8 pt-8"></h2>
      <p id="thumbnail-summary" class="text-xl bg-[#11111155] px-8 pb-8"></p>
      <a id="thumbnail-button" class="shadow-black shadow-sm hidden bg-cyan-600 mx-8 px-4 py-2 text-lg font-bold my-6"></a>
    </div>
  </div>
  <div class="md:flex-1/4 flex flex-col gap-0">
    <?php foreach ($data["newsLetters"] as $index => $newsLetter): ?>
      <?php if ($newsLetter->bgUrl): ?>
        <link rel="preload" as="image" href="<?= $newsLetter->bgUrl ?>">
      <?php endif ?>
      <button
        id="newsletter-button-<?= $index ?>"
        class="transition-colors duration-500 h-24 cursor-pointer bg-pink-500 flex gap-2 items-center p-2"
        onclick='setNewsLetter(<?= $index ?>)'>
        <svg id="newsletter-button-chevron-<?= $index ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 rotate-0 transition-all duration-500">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="text-left text-lg"><?= $newsLetter->title ?></span>
      </button>
    <?php endforeach; ?>
  </div>

  <script>
    const newsLetters = <?= json_encode($data["newsLetters"]) ?>;
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
          .removeClass("shadow-sm");
        $(`#newsletter-button-chevron-${i}`).removeClass("rotate-180")
          .addClass("rotate-0");
      }
      $(`#newsletter-button-${index}`).removeClass("bg-pink-500")
        .addClass("bg-cyan-600")
        .addClass("shadow-black")
        .addClass("shadow-sm");
      $(`#newsletter-button-chevron-${index}`).removeClass("rotate-0")
        .addClass("rotate-180");
    }
  </script>
</section>
