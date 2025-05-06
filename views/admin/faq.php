<div class="page-heading">
  <h3>FAQ Management</h3>
</div>

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
            <form method="POST" class="mt-3">
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
      <div class="space-y-4 mb-6">
        <?php foreach ($data['faqs'] as $faq) { ?>
          <div class="border rounded-lg p-4 space-y-2">
            <input type="hidden" name="update[<?php echo htmlspecialchars($faq->id); ?>][id]" 
              value="<?php echo htmlspecialchars($faq->id); ?>">
            
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

            <div class="flex justify-end">
              <button type="button" onclick="deleteFAQ('<?php echo htmlspecialchars($faq->id); ?>')" 
                class="btn btn-danger">Delete</button>
            </div>
          </div>
        <?php } ?>
      </div>

      <div class="border rounded-lg p-4 space-y-2 mb-4">
        <h3 class="text-lg font-medium mb-3">Add New FAQ</h3>
        
        <div class="mb-3">
          <label class="form-label">Question *</label>
          <input type="text" name="create[0][question]" class="form-control question-input">
        </div>

        <div class="mb-3">
          <label class="form-label">Answer *</label>
          <textarea name="create[0][answer]" class="form-control answer-input" rows="3"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Category *</label>
          <input type="text" name="create[0][category]" class="form-control category-input">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Save All Changes</button>
    </form>

    <script>
      function deleteFAQ(id) {
        if (confirm('Are you sure you want to delete this FAQ?')) {
          const form = document.getElementById('faqForm');
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'delete[]';
          input.value = id;
          form.appendChild(input);
          form.submit();
        }
      }

      $(document).ready(function() {
        const form = $("#faqForm");

        const validations = {
          question: {
            validate: function(value) {
              return value.length >= 5 && value.length <= 200;
            },
            errorMessage: "Question must be between 5 and 200 characters"
          },
          answer: {
            validate: function(value) {
              return value.length >= 10;
            },
            errorMessage: "Answer must be at least 10 characters"
          },
          category: {
            validate: function(value) {
              return value.length >= 3;
            },
            errorMessage: "Category must be at least 3 characters"
          }
        };

        function validateInput($input, type) {
          const value = $input.val();
          const validation = validations[type];
          const errorId = $input.attr('name') + "-error";

          if (!validation) return true;

          if (!validation.validate(value)) {
            if (!$('#' + errorId).length) {
              $input.after('<p id="' + errorId + '" class="text-sm text-red-600">' + validation.errorMessage + '</p>');
            }
            $input.addClass("border-red-600");
            return false;
          } else {
            $('#' + errorId).remove();
            $input.removeClass("border-red-600");
            return true;
          }
        }

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
      });
    </script>
  </div>
</section>