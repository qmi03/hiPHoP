<div class="page-heading">
  <h3>About Page Management</h3>
</div>

<?php if (isset($_GET['success'])) { ?>
  <div class="alert alert-success">Changes saved successfully!</div>
<?php } elseif (isset($_GET['error'])) { ?>
  <div class="alert alert-danger">Error saving changes. Please try again.</div>
<?php } ?>

<section class="section">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">About Information</h5>
    </div>
    <?php if ($data['about']) { ?>
      <form method="POST" class="card-body" id="aboutForm" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['about']->id); ?>">
        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($data['about']->image_path); ?>">
        
        <div class="mb-3">
          <label for="title" class="form-label">Title *</label>
          <input type="text" id="title" name="title" class="form-control" required 
            value="<?php echo htmlspecialchars($data['about']->title); ?>">
        </div>

        <div class="mb-3">
          <label for="content" class="form-label">Content *</label>
          <textarea id="content" name="content" rows="10" class="form-control" required><?php echo htmlspecialchars($data['about']->content); ?></textarea>
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Image *</label>
          <input type="file" id="image" name="image" class="form-control" accept="image/*"
            <?php echo empty($data['about']->image_path) ? 'required' : ''; ?>>
          <?php if (!empty($data['about']->image_path)) { ?>
            <div class="mt-2">
              <img src="<?php echo htmlspecialchars($data['about']->image_path); ?>" 
                alt="Current image" 
                class="max-w-xs image-preview">
              <p class="text-sm text-gray-600 mt-1">Current image: <?php echo htmlspecialchars(basename($data['about']->image_path)); ?></p>
            </div>
          <?php } ?>
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
            },
            'image': {
              validate: function(input) {
                if (!input.files || !input.files[0]) return true; // Skip if no new file
                const file = input.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                return validTypes.includes(file.type) && file.size <= maxSize;
              },
              errorMessage: "Please select a valid image file (JPG, PNG, GIF, WEBP) under 5MB"
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

            if (field === 'image') {
              if (!validation.validate($field[0])) {
                addErrorMessage(field, validation.errorMessage);
                return false;
              } else {
                removeErrorMessage(field);
                return true;
              }
            }

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
            }
          });

          Object.keys(validations).forEach(function(field) {
            $("#" + field).on("input blur change", function() {
              validateField(field);
            });
          });

          // Update image preview on file select
          $("#image").on('change', function() {
            const file = this.files[0];
            if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                $('.image-preview').attr('src', e.target.result);
              };
              reader.readAsDataURL(file);
            }
          });
        });
      </script>

      <style>
        .image-preview {
          max-width: 300px;
          max-height: 200px;
          object-fit: contain;
        }
        .image-preview.error {
          border: 2px solid #dc3545;
        }
      </style>
    <?php } ?>
  </div>
</section>