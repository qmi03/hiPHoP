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
          <input type="text" id="introduction-title" name="title" class="form-control" required value="<?php echo htmlspecialchars($data['introduction']->title); ?>">
          <?php if ('introduction-title' == $data['invalidField']) { ?>
            <p class="text-sm text-red-600">Introduction title must not be empty!</p>
          <?php } ?>
        </div>
        <div class="mb-3">
          <label for="introduction-paragraphs" class="form-label">Content *</label>
          <textarea required rows="5" class="form-control" id="introduction-paragraphs" name="paragraphs"><?php echo htmlspecialchars(join("\n", $data['introduction']->paragraphs)); ?></textarea>
          <?php if ('introduction-paragraphs' == $data['invalidField']) { ?>
            <p class="text-sm text-red-600">Introduction paragraphs must not be empty!</p>
          <?php } ?>
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
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-dark">
              <tr>
                <th>AUTHOR</th>
                <th>QUOTE</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data["quote"] as $q): ?>
                <tr>
                  <td class="text-bold-500"><?= $q->author ?></td>
                  <td><?= $q->content ?></td>
                  <td>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
