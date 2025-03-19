<div class="page-heading">
  <h3>Home page</h3>
</div>
<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Newsletters</h5>
      </div>
      <div class="card-body">
      </div>
      <div class="card-footer">
      </div>
    </div>
  </section>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Introduction</h5>
      </div>
      <form method="POST" action="/admin/home-page?introduction-update=true" class="card-body items-stretch">
        <div class="mb-3">
          <label for="introduction-title" class="form-label">Title *</label>
          <input type="text" id="introduction-title" name="title" class="form-control" required value="<?= htmlspecialchars($data["introduction"]->title) ?>">
          <?php if ($data["invalidField"] == "introduction-title"): ?>
            <p class="text-sm text-red-600">Introduction title must not be empty!</p>
          <?php endif ?>
        </div>
        <div class="mb-3">
          <label for="introduction-paragraphs" class="form-label">Content *</label>
          <textarea required rows="5" class="form-control" id="introduction-paragraphs" name="paragraphs"><?= htmlspecialchars(join("\n", $data["introduction"]->paragraphs)) ?></textarea>
          <?php if ($data["invalidField"] == "introduction-paragraphs"): ?>
            <p class="text-sm text-red-600">Introduction paragraphs must not be empty!</p>
          <?php endif ?>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Update</button>
      </form>
    </div>
  </section>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Popular instruments</h5>
      </div>
      <div class="card-body">
      </div>
      <div class="card-footer">
      </div>
    </div>
  </section>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Quotes</h5>
      </div>
      <div class="card-body">
      </div>
      <div class="card-footer">
      </div>
    </div>
  </section>
</div>
