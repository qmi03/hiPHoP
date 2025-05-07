<div class="page-heading">
  <h3>About Page Management</h3>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
          <i class="bi bi-check-circle me-2"></i>Success
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
        <p class="mt-3 mb-0">Changes saved successfully!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success px-4" onclick="window.location.reload()">OK</button>
      </div>
    </div>
  </div>
</div>

<section class="section">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">About Information</h5>
    </div>
    <?php if ($data['about']) { ?>
      <form method="POST" class="card-body" id="aboutForm">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['about']->id); ?>">
        
        <div class="mb-3">
          <label for="title" class="form-label">Title *</label>
          <input type="text" id="title" name="title" class="form-control" required 
            value="<?php echo htmlspecialchars($data['about']->title); ?>">
        </div>

        <div class="mb-3">
          <label for="content" class="form-label">Content *</label>
          <textarea id="content" name="content" rows="10" class="form-control" required><?php echo htmlspecialchars($data['about']->content); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
      </form>

      <script>
        $(document).ready(function() {
          const form = $("#aboutForm");

          const validations = {
            'title': {
              validate: function(value) {
                return value.length >= 3 && value.length <= 100;
              },
              errorMessage: "Title must be between 3 and 100 characters"
            },
            'content': {
              validate: function(value) {
                return value.length >= 10;
              },
              errorMessage: "Content must be at least 10 characters"
            }
          };

          function addErrorMessage(field, message) {
            const $field = $("#" + field);
            const errorId = field + "-error";
            
            if ($("#" + errorId).length === 0) {
              $field.after('<p id="' + errorId + '" class="text-sm text-red-600">' + message + '</p>');
            }
            $field.addClass("border-red-600");
          }

          function removeErrorMessage(field) {
            const $field = $("#" + field);
            const errorId = field + "-error";
            
            $("#" + errorId).remove();
            $field.removeClass("border-red-600");
          }

          function validateField(field) {
            const $field = $("#" + field);
            const value = $field.val();
            const validation = validations[field];

            if (!validation) return true;

            if (!validation.validate(value)) {
              addErrorMessage(field, validation.errorMessage);
              return false;
            } else {
              removeErrorMessage(field);
              return true;
            }
          }

          form.on("submit", function(event) {
            let isValid = true;

            Object.keys(validations).forEach(function(field) {
              if (!validateField(field)) {
                isValid = false;
              }
            });

            if (!isValid) {
              event.preventDefault();
              return;
            }

            event.preventDefault();
            
            $.ajax({
              type: "POST",
              url: form.attr("action"),
              data: form.serialize(),
              success: function() {
                $("#successModal").modal("show");
              },
              error: function() {
                alert("Error saving changes. Please try again.");
              }
            });
          });

          Object.keys(validations).forEach(function(field) {
            $("#" + field).on("input blur change", function() {
              validateField(field);
            });
          });
        });
      </script>
    <?php } ?>
  </div>
</section>