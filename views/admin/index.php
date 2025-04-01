<div class="page-heading">
  <h3>General</h3>
</div>

<section class="section">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Information</h5>
    </div>
    <form method="POST" action="/admin?contact-update=true" class="card-body items-stretch">
      <div class="mb-3">
        <label for="contact-address" class="form-label">Address *</label>
        <input type="text" id="contact-address" name="address" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['address']); ?>">
        <?php if ('contact-address' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact address must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-phone" class="form-label">Tel *</label>
        <input type="text" id="contact-phone" name="phone" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['phone']); ?>">
        <?php if ('contact-phone' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact tel must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-email" class="form-label">Email *</label>
        <input type="text" id="contact-email" name="email" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['email']); ?>">
        <?php if ('contact-email' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact email must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-facebook" class="form-label">Facebook *</label>
        <input type="text" id="contact-facebook" name="facebook" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['facebook']); ?>">
        <?php if ('contact-facebook' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact facebook must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-github" class="form-label">Github *</label>
        <input type="text" id="contact-github" name="github" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['github']); ?>">
        <?php if ('contact-github' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact github must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-longitude" class="form-label">Longitude *</label>
        <input type="number" step="0.0001" id="contact-longitude" name="longitude" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['longitude']); ?>">
        <?php if ('contact-longitude' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact longitude must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-latitude" class="form-label">Latitude *</label>
        <input type="number" step="0.0001" id="contact-latitude" name="latitude" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['latitude']); ?>">
        <?php if ('contact-latitude' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact latitude must not be empty!</p>
        <?php } ?>
      </div>
      <button type="submit" class="btn btn-primary mb-3">Update</button>
    </form>
  </div>
</section>

<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Photo Gallery</h5>
        <div class="mb-2 flex gap-3 items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
          <form method="get" action="/admin" style="width: 100%">
            <input type="search" class="form-control" style="width: 100%" placeholder="Search image" name="photo-query">
            <input type="submit" hidden />
          </form>
        </div>
      </div>
      <div class="card-body">
        <?php if (0 == $data['photoCount']) { ?>
          <p>No photo yet!</p>
        <?php } elseif (0 == count($data['photos'])) { ?>
          <p>No photo on this page!</p>
        <?php } else { ?>
          <div class="row gallery">
            <?php foreach ($data['photos'] as $index => $photo) { ?>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#image-preview-<?php echo $index; ?>"><img class="h-64 w-100 object-cover active" src="<?php echo htmlspecialchars($photo->url); ?>"></a>
                <div class="modal fade" id="image-preview-<?php echo $index; ?>" tabindex="-1" aria-labelledby="image-preview-<?php echo $index; ?>" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5"><?php echo htmlspecialchars($photo->name); ?></h1>
                      </div>
                      <div class="modal-body">
                        <img src="<?php echo htmlspecialchars($photo->url); ?>">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form method="post" action="/admin?delete-photo=<?php echo $photo->id; ?>">
                          <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
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
  </section>

  <script>
    let currentPage;
    updateCurrentPage(<?php echo htmlspecialchars($data['currentPhotoPage']); ?>);

    function firstPage() {
      return Math.floor(currentPage / 3) * 3;
    }

    function updateCurrentPage(page) {
      currentPage = page;
      $("#page-item-1").removeClass("hidden").children("a").first().text(firstPage() + 1).attr("href", `/admin?gallery-page=${firstPage()}`).removeClass("active");
      $("#page-item-2").removeClass("hidden").children("a").first().text(firstPage() + 2).attr("href", `/admin?gallery-page=${firstPage() + 1}`).removeClass("active");
      $("#page-item-3").removeClass("hidden").children("a").first().text(firstPage() + 3).attr("href", `/admin?gallery-page=${firstPage() + 2}`).removeClass("active");
      if (firstPage() === currentPage) {
        $("#page-item-1").children("a").first().addClass("active");
      } else if (firstPage() + 1 === currentPage) {
        $("#page-item-2").children("a").first().addClass("active");
      } else if (firstPage() + 2 === currentPage) {
        $("#page-item-3").children("a").first().addClass("active");
      }

      if (firstPage() + 1 > <?php echo $data['totalPhotoPages']; ?>) {
        $("#page-item-2").addClass("hidden");
      }
      if (firstPage() + 2 > <?php echo $data['totalPhotoPages']; ?>) {
        $("#page-item-3").addClass("hidden");
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
      if (Math.floor(currentPage / 3) >= Math.floor(<?php echo $data['totalPhotoPages']; ?> / 3)) {
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
      <form method="POST" action="/admin?upload-photo" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label cursor-pointer" for="image-name">Name *</label>
          <input type="text" required class="form-control" name="name" id="image-name">
          <?php if ('name' == $data['invalidPhotoField']) { ?>
            <p class="text-red-600">Invalid name!</p>
          <?php } ?>
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
          <?php if ('filepond' == $data['invalidPhotoField']) { ?>
            <p class="text-red-600">Please add a photo!</p>
          <?php } ?>
        </div>
        <div>
          <input type="submit" class="btn btn-primary mb-3" value="Upload">
        </div>
      </form>
    </div>
  </section>
</div>
