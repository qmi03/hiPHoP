<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Identity of your music experience!</h1>
</section>

<section class="bg-white mx-5 lg:mx-20 p-10 relative top-[-10px]">
  <form action="/account?update=true" method="post" class="flex flex-col lg:grid grid-cols-[200px_1fr] gap-x-5 lg:gap-y-5 text-xl">
    <label class="text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="avatar">Avatar *</label>
    <div>
      <input type="file" id="avatar" class="hidden" accept="image/*" required>
      <input type="text" id="avatar-data-url" name="avatarDataUrl" class="hidden" value="<?php echo $data['avatarDataUrl']; ?>">
      <div class="flex items-center justify-center">
        <label class="block relative" for="avatar">
          <img id="user-avatar-display" width="200px" height="200px" class="block h-[200px] w-[200px] rounded-full" alt="user avatar" src="<?php echo $data['avatarUrl']; ?>">
          <div class="absolute top-[-10px] left-[-10px] h-[220px] w-[220px] rounded-full bg-[#55555522] hover:bg-[#55555577] transition-all shadow-sm z-50 cursor-pointer">
          </div>
        </label>
      </div>
      <br class="lg:hidden">
    </div>
    <label class="text-left lg:text-right lg:self-center cursor-pointer" for="username">Username</label>
    <input class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic bg-gray-100" id="username" value="<?php echo htmlspecialchars($data['username']); ?>" disabled>
    <?php if ('username' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid username or it has been taken!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="firstname">First name *</label>
    <input required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="firstname" name="firstname" value="<?php echo htmlspecialchars($data['firstname']); ?>">
    <?php if ('firstname' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid first name!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="lastname">Last name *</label>
    <input required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="lastname" name="lastname" value="<?php echo htmlspecialchars($data['lastname']); ?>">
    <?php if ('lastname' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid last name!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right lg:self-center cursor-pointer" for="email">Email</label>
    <input type="email" class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic bg-gray-100" value="<?php echo htmlspecialchars($data['email']); ?>" disabled>
    <?php if ('email' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid email or email is already taken!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right lg:self-center cursor-pointer" for="old-password">Old password</label>
    <input class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg" type="password" id="old-password" minlength="6" maxlength="256" name="old-password">
    <?php if ('old-password' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Wrong password!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right lg:self-center cursor-pointer" for="new-password">New password</label>
    <input class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg" type="password" id="new-password" minlength="6" maxlength="256" name="new-password">
    <?php if ('new-password' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Password length must be between 6 and 256 characters!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right lg:self-center cursor-pointer" for="re-password">Re-enter password</label>
    <input class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg" type="password" id="re-password" minlength="6" maxlength="256" name="re-password">
    <?php if ('re-password' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Re-entered password does not match!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="dob">Date of birth *</label>
    <input type="date" required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="dob" name="dob" value="<?php echo htmlspecialchars($data['dob']->format('Y-m-d')); ?>">
    <?php if ('dob' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid date of birth!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="address">Address *</label>
    <input required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="address" name="address" value="<?php echo htmlspecialchars($data['address']); ?>">
    <?php if ('address' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid address!</p>
    <?php } ?>
    <div></div>
    <div class="mt-5 lg:mt-0 flex items-center justify-start lg:none">
      <input type="submit" value="UPDATE" class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors">
    </div>
  </form>

  <div class="mt-10">
    <a href="/login/forgot-password" class="text-cyan-600 flex gap-5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
      <span class="text-lg hover:text-black transition-colors duration-300">Forgot your password?</span>
    </a>
  </div>

  <script>
    $(document).ready(function() {
      const form = $("form[action='/account?update=true']");

      const validations = {
        firstname: {
          validate: function(value) {
            return /^[A-Za-z\s\-']{1,50}$/.test(value);
          },
          errorMessage: "First name must contain only letters, spaces, hyphens, or apostrophes (1-50 characters)"
        },
        lastname: {
          validate: function(value) {
            return /^[A-Za-z\s\-']{1,50}$/.test(value);
          },
          errorMessage: "Last name must contain only letters, spaces, hyphens, or apostrophes (1-50 characters)"
        },
        'old-password': {
          validate: function(value) {
            return !value || (value.length >= 6 && value.length <= 256);
          },
          errorMessage: "Old password must be between 6 and 256 characters"
        },
        'new-password': {
          validate: function(value) {
            return !value || (value.length >= 6 && value.length <= 256);
          },
          errorMessage: "New password must be between 6 and 256 characters"
        },
        're-password': {
          validate: function(value) {
            const newPassword = $("#new-password").val();
            return !newPassword || value === newPassword;
          },
          errorMessage: "Passwords do not match"
        },
        dob: {
          validate: function(value) {
            const dobDate = new Date(value);
            return dobDate;
          },
          errorMessage: "Date of birth must no be empty"
        },
        address: {
          validate: function(value) {
            return value.length >= 5 && value.length <= 100;
          },
          errorMessage: "Address must be between 5 and 100 characters"
        }
      };

      function addErrorMessage(field, message) {
        const $field = $("#" + field);
        const errorId = field + "-error";

        if ($("#" + errorId).length === 0) {
          if ($field.closest('.lg\\:grid').length > 0) {
            $field.after('<div></div><p id="' + errorId + '" class="text-sm text-red-600">' + message + '</p>');
          } else {
            $field.after('<p id="' + errorId + '" class="text-sm text-red-600">' + message + '</p>');
          }
        }

        $field.addClass("border-red-600");
      }

      function removeErrorMessage(field) {
        const $field = $("#" + field);
        const errorId = field + "-error";

        $("#" + errorId).remove();

        if ($field.next().is("div") && $field.next().next().attr("id") === errorId) {
          $field.next().remove();
        }

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

        const newPassword = $("#new-password").val();
        const oldPassword = $("#old-password").val();
        if (newPassword && !oldPassword) {
          addErrorMessage('old-password', 'Please enter old password to change password');
          isValid = false;
        }

        if (!isValid) {
          event.preventDefault();
        }
      });

      Object.keys(validations).forEach(function(field) {
        $("#" + field).on("input blur", function() {
          validateField(field);
        });
      });

      $("#avatar").on("change", function(e) {
        const file = e.target.files[0];
        if (!file) {
          return;
        }
        if (!file.type.match("image.*")) {
          alert("Please select an image file");
          return;
        }
        const reader = new FileReader();
        reader.onload = function(loadEvent) {
          const dataURL = loadEvent.target.result;
          $("#user-avatar-display").attr("src", dataURL);
          $("#avatar-data-url").val(dataURL);
        };
        reader.readAsDataURL(file);
      });
    });
  </script>
</section>
