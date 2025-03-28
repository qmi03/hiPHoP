<div class="page-heading">
  <h3>Home page</h3>
</div>
<div class="page-content">
  <section class="section">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Newsletters</h5>
        <button id="addNewsletterBtn" class="btn btn-primary btn-sm me-2">+</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="newslettersTable" class="table table-hover mb-0">
            <thead class="thead-dark">
              <tr>
                <th>TITLE</th>
                <th>SUMMARY</th>
                <th>TARGET URL</th>
                <th>TARGET NAME</th>
                <th>BACKGROUND</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody id="newslettersTableBody">
            </tbody>
          </table>
          <button id="submitNewsletterChangesBtn" class="btn btn-success btn-sm mt-3">Submit Changes</button>
        </div>
      </div>
    </div>

    <div class="modal fade" id="newsletterModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newsletterModalTitle">Add/Edit Newsletter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="newsletterForm">
              <input type="hidden" id="newsletterIndex" name="newsletterIndex">
              <input type="hidden" id="newsletterId" name="newsletterId">
              <div class="mb-3">
                <label for="titleInput" class="form-label">Title *</label>
                <input type="text" class="form-control" id="titleInput" required>
              </div>
              <div class="mb-3">
                <label for="summaryInput" class="form-label">Summary *</label>
                <textarea class="form-control" id="summaryInput" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="targetUrlInput" class="form-label">Target URL</label>
                <input type="url" class="form-control" id="targetUrlInput">
              </div>
              <div class="mb-3">
                <label for="targetNameInput" class="form-label">Target Name</label>
                <input type="text" class="form-control" id="targetNameInput">
              </div>
              <div class="mb-3">
                <label for="backgroundInput" class="form-label" required>Background Image *</label>
                <div class="relative">
                  <input
                    type="text"
                    id="backgroundInput"
                    placeholder="Enter photo name..."
                    class="form-control">
                  <div
                    id="searchResults"
                    class="absolute z-10 w-fill mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-52 w-[100%] overflow-y-auto hidden">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Newsletter</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function debounce(func, delay) {
        let timeoutId;
        return function() {
          const context = this;
          const args = arguments;
          clearTimeout(timeoutId);
          timeoutId = setTimeout(() => {
            func.apply(context, args);
          }, delay);
        };
      }

      async function searchPhotos(keyword = '') {
        const searchResults = document.getElementById('searchResults');

        searchResults.innerHTML = '';
        searchResults.classList.add('hidden');

        try {
          const formData = new FormData();
          formData.append('keyword', keyword);
          formData.append('pageSize', keyword ? 5 : 12);

          const response = await fetch('/api/search-photos', {
            method: 'POST',
            body: formData
          });

          if (!response.ok) {
            throw new Error('Network response was not ok');
          }

          const data = await response.json();

          if (!data.photos.length) {
            return;
          }

          searchResults.classList.remove('hidden');

          data.photos.forEach(photo => {
            const photoDiv = document.createElement('div');
            photoDiv.className = `
                    flex items-center p-2 hover:bg-gray-100 cursor-pointer 
                    transition duration-300 border-b border-gray-200 last:border-b-0
                `;

            const img = document.createElement('img');
            img.src = photo.url;
            img.alt = photo.name;
            img.className = 'w-16 h-16 object-cover rounded mr-4';

            const textDiv = document.createElement('div');

            const name = document.createElement('p');
            name.textContent = photo.name;
            name.className = 'text-gray-800 font-semibold';

            textDiv.appendChild(name);
            photoDiv.appendChild(img);
            photoDiv.appendChild(textDiv);

            photoDiv.addEventListener('click', () => {
              const input = document.getElementById('backgroundInput');
              input.value = photo.url;
              searchResults.classList.add('hidden');
            });

            searchResults.appendChild(photoDiv);
          });

        } catch (error) {
          console.error('Error:', error);
          searchResults.innerHTML = `
                <div class="text-center text-red-500 p-4">
                    <p>Error loading photos: ${error.message}</p>
                </div>
            `;
          searchResults.classList.remove('hidden');
        }
      }

      const debouncedSearch = debounce(function() {
        const keyword = this.value.trim();

        if (keyword === '') {
          searchPhotos();
        } else {
          searchPhotos(keyword);
        }
      }, 300);

      const backgroundInput = document.getElementById('backgroundInput');
      backgroundInput.addEventListener('input', debouncedSearch);

      document.addEventListener('click', (event) => {
        const searchResults = document.getElementById('searchResults');
        const backgroundInput = document.getElementById('backgroundInput');

        if (!searchResults.contains(event.target) &&
          event.target !== backgroundInput) {
          searchResults.classList.add('hidden');
        }
      });

      searchPhotos();
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const newslettersTableBody = document.getElementById('newslettersTableBody');
        const newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
        const newsletterForm = document.getElementById('newsletterForm');
        const addNewsletterBtn = document.getElementById('addNewsletterBtn');
        const submitNewsletterChangesBtn = document.getElementById('submitNewsletterChangesBtn');
        const newsletterModalTitle = document.getElementById('newsletterModalTitle');

        let newsletters = <?= json_encode($data['newsLetters']) ?>;

        let changedNewsletters = {};
        let createdNewsletters = {};
        let deletedNewsletterIds = [];
        let nextTempId = 10000;

        function renderNewsletters() {
          newslettersTableBody.innerHTML = newsletters.map((newsletter, index) => `
                    <tr>
                        <td>${newsletter.title}</td>
                        <td>${newsletter.summary}</td>
                        <td>${newsletter.targetUrl || 'N/A'}</td>
                        <td>${newsletter.targetName || 'N/A'}</td>
                        <td>
                          <img src="${newsletter.bgUrl}" alt="Background" style="max-width: 100px; max-height: 50px;">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary newsletter-edit-btn" data-index="${index}">Edit</button>
                            <button class="btn btn-sm btn-outline-danger newsletter-delete-btn" data-index="${index}">Delete</button>
                        </td>
                    </tr>
                `).join('');

          document.querySelectorAll('.newsletter-edit-btn').forEach(btn => {
            btn.addEventListener('click', handleNewsletterEdit);
          });

          document.querySelectorAll('.newsletter-delete-btn').forEach(btn => {
            btn.addEventListener('click', handleNewsletterDelete);
          });
        }

        function handleNewsletterEdit(event) {
          const index = event.target.dataset.index;
          const newsletter = newsletters[index];

          $('#newsletterIndex').val(index);
          $('#newsletterId').val(newsletter.id);
          $('#titleInput').val(newsletter.title);
          $('#summaryInput').val(newsletter.summary);
          $('#targetUrlInput').val(newsletter.targetUrl || '');
          $('#targetNameInput').val(newsletter.targetName || '');
          $('#backgroundInput').val(newsletter.bgUrl || '');

          newsletterModalTitle.textContent = 'Edit Newsletter';
          newsletterModal.show();
        }

        function handleNewsletterDelete(event) {
          const index = event.target.dataset.index;
          const newsletter = newsletters[index];

          if (confirm('Are you sure you want to delete this newsletter?')) {
            if (newsletter.id < 10000) {
              deletedNewsletterIds.push(newsletter.id);
            } else {
              delete createdNewsletters[newsletter.id];
            }

            newsletters.splice(index, 1);
            renderNewsletters();
          }
        }

        addNewsletterBtn.addEventListener('click', function() {
          newsletterForm.reset();
          $('#newsletterIndex').val('');
          const newNewsletterId = nextTempId++;
          $('#newsletterId').val(newNewsletterId);
          newsletterModalTitle.textContent = 'Add New Newsletter';
          newsletterModal.show();
        });

        newsletterForm.addEventListener('submit', function(event) {
          event.preventDefault();

          const index = $('#newsletterIndex').val();
          const newsletterId = $('#newsletterId').val();
          const title = $('#titleInput').val();
          const summary = $('#summaryInput').val();
          const targetUrl = $('#targetUrlInput').val() || null;
          const targetName = $('#targetNameInput').val() || null;
          const backgroundInput = $('#backgroundInput').val() || null;

          const newNewsletter = {
            id: newsletterId,
            title,
            summary,
            targetUrl,
            targetName,
            bgUrl: backgroundInput,
          };

          if (index === '') {
            newsletters.push(newNewsletter);
            createdNewsletters[newsletterId] = {
              title,
              summary,
              targetUrl,
              targetName,
              bgUrl: backgroundInput
            };
          } else {
            const newsletter = newsletters[index];

            const newsletterChanged =
              newsletter.title !== title ||
              newsletter.summary !== summary ||
              newsletter.targetUrl !== targetUrl ||
              newsletter.targetName !== targetName ||
              newsletter.bgUrl !== backgroundInput;

            if (newsletterChanged) {
              if (newsletter.id < 10000) {
                changedNewsletters[newsletter.id] = {
                  title,
                  summary,
                  targetUrl,
                  targetName,
                  bgUrl: backgroundInput,
                };
              }

              newsletter.title = title;
              newsletter.summary = summary;
              newsletter.targetUrl = targetUrl;
              newsletter.targetName = targetName;
              newsletter.bgUrl = backgroundInput;
            }
          }

          renderNewsletters();
          newsletterModal.hide();
        });

        submitNewsletterChangesBtn.addEventListener('click', function() {
          const formData = new FormData();

          console.log(changedNewsletters);

          Object.entries(changedNewsletters).forEach(([id, newsletter]) => {
            formData.append(`changed[${id}][title]`, newsletter.title);
            formData.append(`changed[${id}][summary]`, newsletter.summary);
            formData.append(`changed[${id}][targetUrl]`, newsletter.targetUrl || '');
            formData.append(`changed[${id}][targetName]`, newsletter.targetName || '');
            formData.append(`changed[${id}][bgUrl]`, newsletter.bgUrl);
          });

          Object.values(createdNewsletters).forEach((newsletter, index) => {
            formData.append(`created[${index}][title]`, newsletter.title);
            formData.append(`created[${index}][summary]`, newsletter.summary);
            formData.append(`created[${index}][targetUrl]`, newsletter.targetUrl || '');
            formData.append(`created[${index}][targetName]`, newsletter.targetName || '');
            formData.append(`created[${index}][bgUrl]`, newsletter.bgUrl);
          });

          deletedNewsletterIds.forEach((id, index) => {
            formData.append(`deleted[${index}]`, id);
          });

          fetch('/admin/home-page?newsletter-update=true', {
            method: 'POST',
            body: formData
          }).then(() => location.reload());
        });

        renderNewsletters();
      });
    </script>
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
        <h5 class="card-title m-0">Quotes</h5>
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
                    <button class="btn btn-sm btn-outline-primary quote-edit-btn" data-index="${index}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger quote-delete-btn" data-index="${index}">Delete</button>
                </td>
            </tr>
        `).join('');

          document.querySelectorAll('.quote-edit-btn').forEach(btn => {
            btn.addEventListener('click', handleQuoteEdit);
          });

          document.querySelectorAll('.quote-delete-btn').forEach(btn => {
            btn.addEventListener('click', handleQuoteDelete);
          });
        }

        function handleQuoteEdit(event) {
          const index = event.target.dataset.index;
          const quote = quotes[index];

          $('#quoteIndex').val(index);
          $('#quoteId').val(quote.id);
          $('#authorInput').val(quote.author);
          $('#quoteInput').val(quote.content);

          modalTitle.textContent = 'Edit Quote';
          quoteModal.show();
        }

        function handleQuoteDelete(event) {
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
