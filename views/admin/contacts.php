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
                      onclick="showMessage(<?= $message->id ?>)"
                    >
                      <?= $message->respondedAt == null
                        ? 'View & Reply'
                        : 'View'
                      ?>
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

  <div class="modal fade modal-lg" id="view-message-modal" tabindex="-1" role="dialog" aria-labelledby="view-message-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="view-message-modal-title">View message</h5>
          <button type="button" class="close" aria-label="Close" onclick="hideMessageModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="message-metadata">
            Sent by <span class="font-bold" id="message-username"></span> at <span class="font-bold" id="message-created-at"></span>
          </div>
          <textarea class="form-control mt-2" id="message-content" rows="5" readonly disabled></textarea>
          <form id="message-form" class="mt-2">
            <input type="hidden" name="id" id="message-id">
            <div class="form-group">
              <label for="message-response">Reply</label>
              <textarea class="form-control mt-2" id="message-response" rows="5" name="response"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="hideMessageModal()">Close</button>
          <button type="button" id="btn-submit-reply" class="btn btn-primary d-none" onclick="submitReply()">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const pageData = <?= json_encode($data) ?>;

function showMessage(id) {
  const message = pageData.paginatedMessages.find(m => m.id === id);
  if (!message) {
    console.error('Message not found');
    return;
  }
  $('#view-message-modal-title').text(`View message: ${message.title}`);
  $('#message-id').val(message.id);
  $('#message-username').text(message.username);
  $('#message-created-at').text(message.createdAt.date);
  $('#message-content').val(message.message);
  if (message.respondedAt == null) {
    $('#btn-submit-reply').removeClass('d-none');
    $('#message-response').attr('disabled', false).attr('readonly', false).val('');
  } else {
    $('#btn-submit-reply').addClass('d-none');
    $('#message-response').attr('disabled', true).attr('readonly', true).val(message.response);
  }
  $('#view-message-modal').modal('show');
}

function hideMessageModal() {
  $('#view-message-modal').modal('hide');
}

function submitReply() {
  const form = $('#message-form');
  const formData = new FormData(form[0]);
  if (!formData.get('response')) {
    alert('Please enter a reply message.');
    return;
  }
  $.ajax({
    url: '/admin/contacts?reply=true',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      if (response.status === 'success') {
        alert(response.message);
        hideMessageModal();
        location.reload();
      } else {
        alert('Failed to send reply. Please try again.');
      }
    },
    error: function() {
      alert('An error occurred. Please try again.');
    }
  });
}

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