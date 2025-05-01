<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Remember the way to your music experience!</h1>
</section>
<section class="bg-white mx-5 lg:mx-20 p-10 relative top-[-10px]">
  <form action="/login/forgot-password" method="post" class="flex flex-col lg:grid grid-cols-[200px_1fr] gap-x-5 lg:gap-y-5 text-xl">
    <label class="text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="email">Email *</label>
    <input type="email" required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="email" name="email">
    <div></div>
    <div class="mt-5 lg:mt-0 flex items-center justify-start lg:none">
      <input type="submit" value="SEND RECOVERY MAIL" class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors">
    </div>
  </form>

  <div class="mt-10">
    <a href="/signup" class="text-cyan-600 flex gap-5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
      <span class="text-lg hover:text-black transition-colors duration-300">Do not have an account?</span>
    </a>
    <a href="/login" class="text-cyan-600 flex gap-5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
      <span class="text-lg hover:text-black transition-colors duration-300">Remember your password?</span>
    </a>
  </div>
</section>

<script>
$(document).ready(function() {
  const form = $("form[action='/login/forgot-password']");

  const emailValidation = {
    validate: function(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    },
    errorMessage: "Please enter a valid email address!"
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

    if ($field.next().is("div") && $field.next().next().attr("id") === errorId) {
      $field.next().remove();
    }

    $("#" + errorId).remove();

    $field.removeClass("border-red-600");
  }

  function validateEmail() {
    const emailField = "email";
    const $emailField = $("#" + emailField);
    const value = $emailField.val();

    if (!emailValidation.validate(value)) {
      addErrorMessage(emailField, emailValidation.errorMessage);
      return false;
    } else {
      removeErrorMessage(emailField);
      return true;
    }
  }

  form.on("submit", function(event) {
    const isValid = validateEmail();

    if (!isValid) {
      event.preventDefault();
    } else {
      const $submitButton = $(this).find("input[type='submit']");
      const originalValue = $submitButton.val();

      $submitButton.val("Sending...").addClass("opacity-70").prop("disabled", true);

      return true;
    }
  });

  $("#email").on("input blur", function() {
    validateEmail();
  });
});
</script>
