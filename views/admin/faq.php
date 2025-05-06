<div class="page-heading">
  <h3>FAQ Management</h3>
</div>

<?php if (!empty($data['message'])): ?>
<div class="alert alert-success">
    <?php echo htmlspecialchars($data['message']); ?>
</div>
<?php endif; ?>

<?php if (!empty($data['error'])): ?>
<div class="alert alert-danger">
    <?php echo htmlspecialchars($data['error']); ?>
</div>
<?php endif; ?>

<section class="section">
  <!-- User Questions Section -->
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="card-title">User Questions</h5>
    </div>
    <div class="card-body">
      <?php if (empty($data['userQuestions'])): ?>
        <p>No new questions from users.</p>
      <?php else: ?>
        <?php foreach ($data['userQuestions'] as $question): ?>
          <div class="border rounded-lg p-4 mb-4">
            <div class="mb-2">
              <strong>From:</strong> <?php echo htmlspecialchars($question['username']); ?> 
              (<?php echo htmlspecialchars($question['email']); ?>)
            </div>
            <div class="mb-2">
              <strong>Question:</strong> <?php echo htmlspecialchars($question['content']); ?>
            </div>
            <div class="mb-2">
              <strong>Asked:</strong> <?php echo $question['createdAt']->format('Y-m-d H:i'); ?>
            </div>
            <form method="POST" name="answer_form" class="mt-3">
              <input type="hidden" name="answer_question[id]" value="<?php echo $question['id']; ?>">
              <div class="mb-3">
                <label class="form-label">Your Answer</label>
                <textarea name="answer_question[answer]" class="form-control" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit Answer</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- FAQs Section -->
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Frequently Asked Questions</h5>
    </div>
    
    <form method="POST" id="faqForm" class="card-body">
      <input type="hidden" name="action" id="formAction" value="">
      
      <div class="space-y-4 mb-6" id="existingFaqs">
        <!-- Existing FAQs -->
        <?php foreach ($data['faqs'] as $faq): ?>
          <div class="border rounded-lg p-4 space-y-2">
            <div class="mb-3">
              <label class="form-label">Question *</label>
              <input type="text" name="update[<?php echo htmlspecialchars($faq->id); ?>][question]" 
                value="<?php echo htmlspecialchars($faq->question); ?>" 
                class="form-control question-input" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Answer *</label>
              <textarea name="update[<?php echo htmlspecialchars($faq->id); ?>][answer]" 
                class="form-control answer-input" required rows="3"><?php echo htmlspecialchars($faq->answer); ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Category *</label>
              <input type="text" name="update[<?php echo htmlspecialchars($faq->id); ?>][category]" 
                value="<?php echo htmlspecialchars($faq->category); ?>" 
                class="form-control category-input" required>
            </div>

            <div class="flex justify-end space-x-2">
              <button type="button" class="btn btn-primary btn-sm update-faq" 
                data-id="<?php echo htmlspecialchars($faq->id); ?>">Update</button>
              <button type="button" class="btn btn-danger btn-sm delete-faq" 
                data-id="<?php echo htmlspecialchars($faq->id); ?>">Delete</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- New FAQ form -->
      <div id="newFaqContainer">
        <!-- New FAQ fields will be added here -->
      </div>

      <div class="flex space-x-2">
        <button type="button" id="addNewFaq" class="btn btn-secondary">Add New FAQ</button>
        <button type="submit" class="btn btn-primary" id="saveButton">Save All Changes</button>
      </div>
    </form>

    <script>
      $(document).ready(function() {
        let newFaqCount = 1;

        // Handle FAQ update
        $('.update-faq').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const container = $(this).closest('.border');
            
            const form = $('#faqForm');
            form.find('input[name="action"]').val('update');
            form.append($('<input>', {
                type: 'hidden',
                name: 'id',
                value: id
            }));
            
            form.append($('<input>', {
                type: 'hidden',
                name: 'update[question]',
                value: container.find('.question-input').val()
            }));
            
            form.append($('<input>', {
                type: 'hidden',
                name: 'update[answer]',
                value: container.find('.answer-input').val()
            }));
            
            form.append($('<input>', {
                type: 'hidden',
                name: 'update[category]',
                value: container.find('.category-input').val()
            }));
            
            form.submit();
        });

        // Handle FAQ deletion
        $('.delete-faq').click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this FAQ?')) {
                const id = $(this).data('id');
                const form = $('#faqForm');
                
                form.find('input[name="action"]').val('delete');
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'id',
                    value: id
                }));
                
                form.submit();
            }
        });

        // Handle new FAQ creation
        $('#addNewFaq').click(function() {
            const template = $('#newFaqTemplate').html();
            const newFaq = $(template);
            $('#newFaqContainer').append(newFaq);
            
            newFaq.find('button.save-new-faq').click(function(e) {
                e.preventDefault();
                const container = $(this).closest('.border');
                const form = $('#faqForm');
                
                if (!validateContainer(container)) {
                  return;
                }
                
                form.find('input[name="action"]').val('create');
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'create[question]',
                    value: container.find('.question-input').val().trim()
                }));
                
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'create[answer]',
                    value: container.find('.answer-input').val().trim()
                }));
                
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'create[category]',
                    value: container.find('.category-input').val().trim()
                }));
                
                form.submit();
            });
        });

        // Handle answer submission for user questions
        $(document).on('submit', 'form[name="answer_form"]', function(e) {
          e.preventDefault();
          const form = $(this);
          const answer = form.find('textarea[name="answer_question[answer]"]').val().trim();
          
          if (answer.length < 10) {
            alert('Answer must be at least 10 characters long');
            return;
          }
          
          $('#faqForm').find('input[name="action"]').val('answer_question');
          form.submit();
        });

        // Enhanced validation
        const validations = {
          question: {
            validate: function(value) {
              const trimmed = value.trim();
              return trimmed.length >= 5 && trimmed.length <= 200;
            },
            errorMessage: "Question must be between 5 and 200 characters"
          },
          answer: {
            validate: function(value) {
              return value.trim().length >= 10;
            },
            errorMessage: "Answer must be at least 10 characters"
          },
          category: {
            validate: function(value) {
              return value.trim().length >= 3;
            },
            errorMessage: "Category must be at least 3 characters"
          }
        };

        // Real-time validation feedback
        function validateInput($input, type) {
          const value = $input.val();
          const validation = validations[type];
          const $group = $input.closest('.mb-3');
          const $feedback = $group.find('.invalid-feedback');

          if (!validation) return true;

          if (!validation.validate(value)) {
            $input.addClass('is-invalid');
            if ($feedback.length === 0) {
              $group.append(`<div class="invalid-feedback">${validation.errorMessage}</div>`);
            }
            return false;
          } else {
            $input.removeClass('is-invalid');
            $feedback.remove();
            return true;
          }
        }

        function validateContainer(container) {
          let isValid = true;
          
          const question = container.find('.question-input').val().trim();
          const answer = container.find('.answer-input').val().trim();
          const category = container.find('.category-input').val().trim();
          
          if (question.length < 5 || question.length > 200) {
            alert('Question must be between 5 and 200 characters');
            isValid = false;
          }
          
          if (answer.length < 10) {
            alert('Answer must be at least 10 characters');
            isValid = false;
          }
          
          if (category.length < 3) {
            alert('Category must be at least 3 characters');
            isValid = false;
          }
          
          return isValid;
        }

        const form = $("#faqForm");
        form.on("submit", function(event) {
          let isValid = true;

          $('.question-input').each(function() {
            if ($(this).val() && !validateInput($(this), 'question')) {
              isValid = false;
            }
          });

          $('.answer-input').each(function() {
            if ($(this).val() && !validateInput($(this), 'answer')) {
              isValid = false;
            }
          });

          $('.category-input').each(function() {
            if ($(this).val() && !validateInput($(this), 'category')) {
              isValid = false;
            }
          });

          if (!isValid) {
            event.preventDefault();
          }
        });

        $('.question-input').on("input blur", function() {
          validateInput($(this), 'question');
        });

        $('.answer-input').on("input blur", function() {
          validateInput($(this), 'answer');
        });

        $('.category-input').on("input blur", function() {
          validateInput($(this), 'category');
        });

        // Add new FAQ row dynamically
        $('#addNewFaq').on('click', function() {
          const template = $('#newFaqTemplate').html();
          const newFaq = template.replace(/\[0\]/g, `[${newFaqCount}]`);
          $('#newFaqContainer').append(newFaq);
          newFaqCount++;
        });
      });
    </script>

    <template id="newFaqTemplate">
      <div class="border rounded-lg p-4 space-y-2 mb-4">
        <div class="mb-3">
          <label class="form-label">Question *</label>
          <input type="text" class="form-control question-input" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Answer *</label>
          <textarea class="form-control answer-input" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Category *</label>
          <input type="text" class="form-control category-input" required>
        </div>

        <div class="flex justify-end space-x-2">
          <button type="button" class="btn btn-primary btn-sm save-new-faq">Save</button>
          <button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('.border').remove()">
            Cancel
          </button>
        </div>
      </div>
    </template>
  </div>
</section>