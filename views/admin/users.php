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
            <input type="search" class="form-control" style="width: 100%" placeholder="Search username/email" name="query">
            <input type="submit" hidden />
          </form>
        </div>
      </div>
      <div class="card-body">
        <?php if (0 == $data['users_count']) { ?>
          <p>No user found!</p>
        <?php } elseif (0 == count($data['paginated_users'])) { ?>
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
              <?php foreach ($data['paginated_users'] as $user): ?>
                <tr>
                  <td><?= $user->id ?></td>
                  <td><?= $user->username ?></td>
                  <td><?= $user->email ?></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary user-edit-btn"
                      data-user-id="<?= $user->id ?>">Edit</button>
                    <button class="btn btn-sm btn-outline-warning user-change-pwd-btn"
                      data-user-id="<?= $user->id ?>">Change
                      Password</button>
                    <button class="btn btn-sm btn-outline-danger user-delete-btn"
                      data-user-id="<?= $user->id ?>">Delete</button>
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
          <li class="page-item">
            <a class="page-link" href="<?= $_SERVER['PATH'] ?>"><?= $data['current_page'] + 1 ?></a>
          </li>
          <li class="page-item" id="page-item-right">
            <a class="page-link cursor-pointer">
              <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </section>
</div>

<script>
  const users = <?= json_encode($data['paginated_users']) ?>;
  const users_count = <?= json_encode($data['users_count']) ?>;
  console.log(users)
  console.log(users_count)
</script>