<div class="page-heading">
  <h3>Home</h3>
</div>
<div class="page-content">
  <section class="section">
    <div class="row">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Photo Gallery</h5>
        </div>
        <div class="card-body">
          <?php if ($data["photoCount"] == 0): ?>
            <p>No photo yet!</p>
          <?php elseif (count($data["photos"]) == 0): ?>
            <p>No photo on this page!</p>
          <?php else: ?>
            <div class="row gallery">
              <?php foreach ($data["photos"] as $photo): ?>
                <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                  <a href="<?= htmlspecialchars($photo->url) ?>"><img class="h-64 w-100 object-cover active" src="<?= htmlspecialchars($photo->url) ?>"></a>
                </div>
              <?php endforeach ?>
            </div>
        </div>
      <?php endif ?>
      </div>
      <div class="card-footer">
        <ul class="pagination pagination-primary">
          <li class="page-item" id="page-item-left"><a class="page-link cursor-pointer">
              <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
            </a></li>
          <li class="page-item" id="page-item-1"><a class="page-link" href="#"></a></li>
          <li class="page-item" id="page-item-2"><a class="page-link" href="#"></a></li>
          <li class="page-item" id="page-item-3"><a class="page-link" href="#"></a></li>
          <li class="page-item" id="page-item-right"><a class="page-link cursor-pointer">
              <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            </a></li>
        </ul>
      </div>
    </div>
</div>
</section>
<script>
  let currentPage;
  updateCurrentPage(<?= htmlspecialchars($data["currentPhotoPage"]) ?>);

  function firstPage() {
    return Math.floor(currentPage / 3) * 3;
  }

  function updateCurrentPage(page) {
    currentPage = page;
    $("#page-item-1").children("a").first().text(firstPage() + 1).attr("href", `/admin?gallery-page=${firstPage()}`).removeClass("active");
    $("#page-item-2").children("a").first().text(firstPage() + 2).attr("href", `/admin?gallery-page=${firstPage() + 1}`).removeClass("active");
    $("#page-item-3").children("a").first().text(firstPage() + 3).attr("href", `/admin?gallery-page=${firstPage() + 2}`).removeClass("active");
    if (firstPage() === currentPage) {
      $("#page-item-1").children("a").first().addClass("active");
    } else if (firstPage() + 1 === currentPage) {
      $("#page-item-2").children("a").first().addClass("active");
    } else if (firstPage() + 2 === currentPage) {
      $("#page-item-3").children("a").first().addClass("active");
    }
  }

  $("#page-item-left").on("click", () => {
    if (currentPage <= 2) {
      return;
    }
    currentPage -= 3;
    updateCurrentPage(firstPage());
  })

  $("#page-item-right").on("click", () => {
    if (Math.floor(currentPage / 3) >= Math.floor(<?= $data["totalPhotoPages"] ?> / 3)) {
      return;
    }
    currentPage += 3;
    updateCurrentPage(firstPage());
  })
</script>

<section class="card">
  <div class="card-header">
    <h5 class="card-title">Photo uploader</h5>
  </div>
  <div class="card-body mt-0">
    <form method="POST" action="/admin/photo/upload" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label cursor-pointer" for="image-name">Name *</label>
        <input type="text" required class="form-control" name="name" id="image-name">
        <?php if ($data["invalidPhotoField"] == "name"): ?>
          <p class="text-red-600">Invalid name!</p>
        <?php endif ?>
      </div>
      <div class="mb-3">
        <!-- File uploader with image preview -->
        <div class="filepond--root image-preview-filepond filepond--hopper" data-style-button-remove-item-position="left" data-style-button-process-item-position="right" data-style-load-indicator-position="right" data-style-progress-indicator-position="right" data-style-button-remove-item-align="false" style="height: 76px;"><input class="filepond--browser" type="file" id="filepond--browser-mr225r250" name="filepond" aria-controls="filepond--assistant-mr225r250" aria-labelledby="filepond--drop-label-mr225r250" accept="image/png,image/jpg,image/jpeg">
          <div class="filepond--drop-label" style="transform: translate3d(0px, 0px, 0px); opacity: 1;"><label for="filepond--browser-mr225r250" id="filepond--drop-label-mr225r250" aria-hidden="true">Drag &amp; Drop your files or <span class="filepond--label-action" tabindex="0">Browse</span></label></div>
          <div class="filepond--list-scroller" style="transform: translate3d(0px, 0px, 0px);">
            <ul class="filepond--list" role="list"></ul>
          </div>
          <div class="filepond--panel filepond--panel-root" data-scalable="true">
            <div class="filepond--panel-top filepond--panel-root"></div>
            <div class="filepond--panel-center filepond--panel-root" style="transform: translate3d(0px, 8px, 0px) scale3d(1, 0.6, 1);"></div>
            <div class="filepond--panel-bottom filepond--panel-root" style="transform: translate3d(0px, 68px, 0px);"></div>
          </div><span class="filepond--assistant" id="filepond--assistant-mr225r250" role="status" aria-live="polite" aria-relevant="additions"></span>
          <fieldset class="filepond--data"></fieldset>
          <div class="filepond--drip"></div>
        </div>
        <?php if ($data["invalidPhotoField"] == "filepond"): ?>
          <p class="text-red-600">Please add a photo!</p>
        <?php endif ?>
      </div>
      <div>
        <input type="submit" class="btn btn-primary mb-3" value="Upload">
      </div>
    </form>
  </div>
</section>
</div>
