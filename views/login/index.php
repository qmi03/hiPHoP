<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Login to your music experience!</h1>
</section>
<section class="bg-white mx-5 lg:mx-20 p-10 relative top-[-10px]">
  <?php if ($data['authFailed']) { ?>
    <p class="text-red-600 mb-5">Email or password is incorrect!</p>
  <?php } ?>
  <form action="/login" method="post" class="flex flex-col lg:grid grid-cols-[200px_1fr] gap-x-5 lg:gap-y-5 text-xl">
    <label class="text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="email">Email *</label>
    <input type="email" required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
    <?php if ('email' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid email!</p>
    <?php } ?>
    <label class="mt-5 lg:mt-0 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="password">Password *</label>
    <input class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg" type="password" required id="password" minlength="6" maxlength="256" name="password">
    <?php if ('password' == $data['invalidField']) { ?>
      <div></div>
      <p class="text-sm text-red-600">Invalid password!</p>
    <?php } ?>
    <div class="mt-5 lg:mt-0 flex gap-5 lg:justify-end">
      <label class="text-left lg:text-right cursor-pointer" for="remember-me-checked">Remember me</label>
      <input type="checkbox" id="remember-me-checked" class="lg:hidden cursor-pointer" name="remember-me-checked">
    </div>
    <div class="hidden lg:flex items-center justify-start cursor-pointer">
      <input type="checkbox" id="remember-me-checked" name="remember-me-checked">
    </div>
    <div></div>
    <div class="mt-5 lg:mt-0 flex items-center justify-start lg:none">
      <input type="submit" value="LOG IN" class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors">
    </div>
  </form>

  <div class="mt-10">
    <a href="/signup" class="text-cyan-600 flex gap-5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
      <span class="text-lg hover:text-black transition-colors duration-300">Do not have an account?</span>
    </a>
    <a href="/login/forgot-password" class="text-cyan-600 flex gap-5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
      <span class="text-lg hover:text-black transition-colors duration-300">Forgot your password?</span>
    </a>
  </div>
</section>

<script>
$(document).ready(function() {
  const form = $("form[action='/login']");
  
  const validations = {
    email: {
      validate: function(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
      },
      errorMessage: "Invalid email!"
    },
    password: {
      validate: function(value) {
        return value.length >= 6 && value.length <= 256;
      },
      errorMessage: "Invalid password!"
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
    
    if (isValid) {
      return true;
    }
    
    event.preventDefault();
  });
  
  Object.keys(validations).forEach(function(field) {
    $("#" + field).on("input blur", function() {
      validateField(field);
      
      if ($(".auth-error-message").length > 0) {
        $(".auth-error-message").fadeOut(300, function() {
          $(this).remove();
        });
      }
    });
  });
  
  $("input[id='remember-me-checked']").on("change", function() {
    const isChecked = $(this).prop("checked");
    $("input[id='remember-me-checked']").prop("checked", isChecked);
  });
});
</script>
