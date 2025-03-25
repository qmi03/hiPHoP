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
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Quotes Management</h5>
        <button id="addQuoteBtn" class="btn btn-primary btn-sm me-2">+</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="quotesTable" class="table table-hover mb-0">
            <thead class="thead-dark">
              <tr>
                <th>AUTHOR</th>
                <th>QUOTE</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="quotesTableBody">
            </tbody>
          </table>
          <button id="submitChangesBtn" class="btn btn-success btn-sm mt-3">Submit Changes</button>
        </div>
      </div>
    </div>

    <div class="modal fade" id="quoteModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Add/Edit Quote</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="quoteForm">
              <input type="hidden" id="quoteIndex" name="quoteIndex">
              <input type="hidden" id="quoteId" name="quoteId">
              <div class="mb-3">
                <label for="authorInput" class="form-label">Author</label>
                <input type="text" class="form-control" id="authorInput" required>
              </div>
              <div class="mb-3">
                <label for="quoteInput" class="form-label">Quote</label>
                <textarea class="form-control" id="quoteInput" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Save Quote</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const quotesTableBody = document.getElementById('quotesTableBody');
        const quoteModal = new bootstrap.Modal(document.getElementById('quoteModal'));
        const quoteForm = document.getElementById('quoteForm');
        const addQuoteBtn = document.getElementById('addQuoteBtn');
        const submitChangesBtn = document.getElementById('submitChangesBtn');
        const modalTitle = document.getElementById('modalTitle');

        let quotes = <?= json_encode($data['quote']) ?>;

        let changedQuotes = {};
        let createdQuotes = {};
        let deletedQuoteIds = [];
        let nextTempId = 10000;

        function renderQuotes() {
          quotesTableBody.innerHTML = quotes.map((quote, index) => `
            <tr>
                <td>${quote.author}</td>
                <td>${quote.content}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary edit-btn" data-index="${index}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger delete-btn" data-index="${index}">Delete</button>
                </td>
            </tr>
        `).join('');

          document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', handleEdit);
          });

          document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', handleDelete);
          });
        }

        function handleEdit(event) {
          const index = event.target.dataset.index;
          const quote = quotes[index];

          $('#quoteIndex').val(index);
          $('#quoteId').val(quote.id);
          $('#authorInput').val(quote.author);
          $('#quoteInput').val(quote.content);

          modalTitle.textContent = 'Edit Quote';
          quoteModal.show();
        }

        function handleDelete(event) {
          const index = event.target.dataset.index;
          const quote = quotes[index];

          if (confirm('Are you sure you want to delete this quote?')) {
            if (quote.id < 10000) {
              deletedQuoteIds.push(quote.id);
            } else {
              delete createdQuotes[quote.id];
            }

            quotes.splice(index, 1);
            renderQuotes();
          }
        }

        addQuoteBtn.addEventListener('click', function() {
          quoteForm.reset();
          $('#quoteIndex').val('');
          const newQuoteId = nextTempId++;
          $('#quoteId').val(newQuoteId);
          modalTitle.textContent = 'Add New Quote';
          quoteModal.show();
        });

        quoteForm.addEventListener('submit', function(event) {
          event.preventDefault();

          const index = $('#quoteIndex').val();
          const quoteId = $('#quoteId').val();
          const author = $('#authorInput').val();
          const content = $('#quoteInput').val();

          if (index === '') {
            const newQuote = {
              id: quoteId,
              author,
              content
            };
            quotes.push(newQuote);

            createdQuotes[quoteId] = {
              author,
              content
            };
          } else {
            const quote = quotes[index];

            if (quote.author !== author || quote.content !== content) {
              if (quote.id < 10000) {
                changedQuotes[quote.id] = {
                  author,
                  content
                };
              }

              quote.author = author;
              quote.content = content;
            }
          }

          renderQuotes();
          quoteModal.hide();
        });

        submitChangesBtn.addEventListener('click', function() {
          const changes = {
            changed: changedQuotes,
            created: Object.values(createdQuotes),
            deleted: deletedQuoteIds
          };

          fetch('/admin/home-page?quote-update=true', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(changes),
          }).then(() => location.reload());
        });

        renderQuotes();
      });
    </script>
  </section>
</div>
