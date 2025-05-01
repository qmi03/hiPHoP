<div class="page-heading">
  <h3>Manage Users</h3>
</div>

<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-header">
        <div class="mb-2 flex gap-3 items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
          <form method="get" action="/admin/users" style="width: 100%">
            <input
              type="search"
              class="form-control"
              style="width: 100%"
              placeholder="Search username/email"
              name="query"
              value="<?= htmlspecialchars($data['query']) ?>" 
            />
            <input type="submit" hidden />
          </form>
        </div>
      </div>
      <div class="card-body">
        <?php if (0 == $data['usersCount']) { ?>
          <p>No user found!</p>
        <?php } elseif (0 == count($data['paginatedUsers'])) { ?>
          <p>No user on this page!</p>
        <?php } else { ?>
          <table id="users-table" class="table table-hover mb-0">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>USERNAME</th>
                <th>EMAIL</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="users-table-body">
              <?php foreach ($data['paginatedUsers'] as $user): ?>
                <tr>
                  <td><?= $user->id ?></td>
                  <td><?= $user->username ?></td>
                  <td><?= $user->email ?></td>
                  <td>
                    <button
                      class="btn btn-sm btn-outline-primary user-edit-btn"
                      onclick="editUser(<?= $user->id ?>)"
                    >
                      Edit
                    </button>
                    <button
                      class="btn btn-sm btn-outline-success user-change-pwd-btn"
                      onclick="changePassword(<?= $user->id ?>)"
                    >
                      Change Password
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

  <div class="modal fade" id="edit-user-password-modal" tabindex="-1" role="dialog" aria-labelledby="edit-user-password-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-user-password-modal-title">Change password</h5>
          <button type="button" class="close" aria-label="Close" onclick="hidePasswordModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="edit-user-password-form">
            <input type="hidden" name="id" id="edit-user-password-id">
            <div class="form-group">
              <label for="edit-password">Password</label>
              <input type="password" class="form-control" id="edit-password" name="password">
            </div>
            <div class="form-group">
              <label for="edit-confirm-password">Confirm password</label>
              <input type="password" class="form-control" id="edit-confirm-password" name="passwordConfirm">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="hidePasswordModal()">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitChangePassword()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const pageData = <?= json_encode($data) ?>;

function populateForm(form, data) {
  $.each(data, function(key, value) {
    var element = $('[name="' + key + '"]', form);
    if (element.length > 0) {
      if (element.is(':checkbox')) {
        element.prop('checked', value);
      } else if (element.is(':radio')) {
        element.filter('[value="' + value + '"]').prop('checked', true);
      } else if (element.is('select')) {
        element.val(value).change();
      } else if (element.is('input[type="date"]')) {
        element.val(value.date.split(' ')[0]);
      } else {
        element.val(value);
      }
    }
  });
}

function editUser(userId) {
  const user = pageData.paginatedUsers.find(user => user.id === userId);
  if (!user) {
    return;
  }
  $('#edit-user-modal-title').text(`Edit "${user.username}" (${user.email})`);
  populateForm('#edit-user-form', user);
  $('#edit-user-modal').modal('show');
}
function hideEditModal() {
  $('#edit-user-modal').modal('hide');
}
function submitEditUser() {
  const form = $('#edit-user-form');
  const formData = new FormData(form[0]);
  $.ajax({
    url: '/admin/users?user-update=true',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      alert(response.message);
      if (response.status === 'success') {
        hideEditModal();
        location.reload();
      }
    },
    error: function() {
      alert('An error occurred. Please try again.');
    }
  });
}

function changePassword(userId) {
  const user = pageData.paginatedUsers.find(user => user.id === userId);
  if (!user) {
    return;
  }
  $('#edit-user-password-modal-title').text(`Change password for "${user.username}" (${user.email})`);
  populateForm('#edit-user-password-form', {
    id: user.id,
    password: '',
    passwordConfirm: '',
  });
  $('#edit-user-password-modal').modal('show');
}
function hidePasswordModal() {
  $('#edit-user-password-modal').modal('hide');
}
function submitChangePassword() {
  const form = $('#edit-user-password-form');
  const formData = new FormData(form[0]);
  $.ajax({
    url: '/admin/users?user-change-password=true',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      alert(response.message);
      if (response.status === 'success') {
        hidePasswordModal();
      }
    },
    error: function() {
      alert('An error occurred. Please try again.');
    }
  });
}

function updateNavigation() {
  const baseUrl = pageData.query
    ? `/admin/users?query=${encodeURIComponent(pageData.query)}&page=`
    : '/admin/users?page='

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