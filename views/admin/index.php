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
          <?php else: ?>
            <div class="row gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100 active" src="https://images.unsplash.com/photo-1633008808000-ce86bff6c1ed?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyN3x8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60">
                </a>
              </div>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=870&amp;q=80">
                </a>
              </div>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100" src="https://images.unsplash.com/photo-1632951634308-d7889939c125?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0M3x8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60">
                </a>
              </div>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100" src="https://images.unsplash.com/photo-1632949107130-fc0d4f747b26?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3OHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60">
                </a>
              </div>
            </div>
            <div class="row mt-2 mt-md-4 gallery">
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100 active" src="https://images.unsplash.com/photo-1633008808000-ce86bff6c1ed?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyN3x8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60">
                </a>
              </div>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100" src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?ixid=MnwxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=870&amp;q=80">
                </a>
              </div>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100" src="https://images.unsplash.com/photo-1632951634308-d7889939c125?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0M3x8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60">
                </a>
              </div>
              <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                <a href="#">
                  <img class="w-100" src="https://images.unsplash.com/photo-1632949107130-fc0d4f747b26?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3OHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60">
                </a>
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
</div>

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
