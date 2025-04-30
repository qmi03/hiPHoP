<div class="page-heading">
  <h3>Contacts</h3>
</div>

<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <?php if (0 == $data['messagesCount']) { ?>
          <p>No message found!</p>
        <?php } elseif (0 == count($data['paginatedMessages'])) { ?>
          <p>No message on this page!</p>
        <?php } else { ?>
          <table id="users-table" class="table table-hover mb-0">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>USERNAME</th>
                <th>TITLE</th>
                <th>SENT AT</th>
                <th>REPLIED?</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="users-table-body">
              <?php foreach ($data['paginatedMessages'] as $message): ?>
                <tr>
                  <td><?= $message->id ?></td>
                  <td><?= $message->username ?></td>
                  <td><?= $message->title ?></td>
                  <td><?= $message->createdAt->format('Y-m-d H:i') ?></td>
                  <td>
                    <?= $message->respondedAt == null
                      ? '<span class="text-red-500">NO</span>'
                      : '<span class="text-green-500">YES</span>'
                    ?>
                  </td>
                  <td>
                    <button
                      class="btn btn-sm btn-outline-success user-edit-btn"
                    >
                      View & Reply
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php } ?>
      </div>
      <div class="card-footer">
        <ul class="pagination pagination-primary">
          <li class="page-item" id="page-item-left">
            <a class="page-link cursor-pointer">
              <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
            </a>
          </li>
          <li class="page-item hidden" id="page-item-1"><a class="page-link" href="#"></a></li>
          <li class="page-item hidden" id="page-item-2"><a class="page-link" href="#"></a></li>
          <li class="page-item hidden" id="page-item-3"><a class="page-link" href="#"></a></li>
          <li class="page-item" id="page-item-right">
            <a class="page-link cursor-pointer">
              <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-user-modal-title">Edit user</h5>
          <button type="button" class="close" aria-label="Close" onclick="hideEditModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="edit-user-form">
            <input type="hidden" name="id" id="edit-user-id">
            <div class="form-group">
              <label for="edit-username">First name</label>
              <input type="text" class="form-control" id="edit-first-name" name="firstName">
            </div>
            <div class="form-group">
              <label for="edit-username">Last name</label>
              <input type="text" class="form-control" id="edit-last-name" name="lastName">
            </div>
            <div class="form-group">
              <label for="edit-username">Address</label>
              <input type="text" class="form-control" id="edit-address" name="address">
            </div>
            <div class="form-group">
              <label for="edit-username">Day of birth</label>
              <input type="date" class="form-control" id="edit-dob" name="dob">
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="edit-is-admin" name="isAdmin">
                <label class="form-check-label" for="edit-is-admin">
                  Is admin
                </label>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="hideEditModal()">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitEditUser()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const pageData = <?= json_encode($data) ?>;

function updateNavigation() {
  const baseUrl = '/admin/contacts?page='

  const prev = $('#page-item-left')
  if (pageData.currentPage > 0) {
    prev.children('a').attr('href', `${baseUrl}${pageData.currentPage - 1}`);
  } else {
    prev.addClass('disabled');
  }
  const next = $('#page-item-right')
  if (pageData.currentPage < pageData.totalPages - 1) {
    next.children('a').attr('href', `${baseUrl}${pageData.currentPage + 1}`);
  } else {
    next.addClass('disabled');
  }
  const pages = [$('#page-item-1'), $('#page-item-2'), $('#page-item-3')]
  const startPage = Math.max(pageData.currentPage - 3, 0);
  pages.forEach((page, idx) => {
    const pageNumber = startPage + idx;
    if (pageNumber < pageData.totalPages) {
      page.removeClass('hidden');
      page.children('a').text(pageNumber + 1);
      page.children('a').attr('href', `${baseUrl}${pageNumber}`);
    } else {
      page.addClass('hidden');
    }
    if (pageNumber === pageData.currentPage) {
      page.addClass('active');
    } else {
      page.removeClass('active');
    }
  })
}

$(document).ready(function() {
  updateNavigation();
})
</script>