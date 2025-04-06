<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Have questions or need support? We're here to help!</h1>
</section>

<section class="bg-white mx-5 lg:mx-20 relative top-[-10px] text-lg md:flex items-center justify-between gap-5">
  <p class="flex-1/3 text-white bg-cyan-600 self-stretch p-10 text-xl font-bold text-center flex items-center justify-center">Our contact info</p>
  <ul class="flex-2/3 px-5 py-5 list-none md:mt-5 text-2xl">
    <li class="flex gap-2 underline text-cyan-600"><span>📧</span><a href="mailto:<?php echo htmlspecialchars($data['email']); ?>"><?php echo htmlspecialchars($data['email']); ?></a></li>
    <li class="mt-3 flex gap-2"><span>📞</span><a href="tel:<?php echo htmlspecialchars($data['phone']); ?>" class="underline text-cyan-600"><?php echo htmlspecialchars($data['phone']); ?></a></li>
    <li class="mt-3 flex gap-2"><span>📍</span><a href="#map" class="underline text-cyan-600"><?php echo htmlspecialchars($data['address']); ?></a></li>
  </ul>
</section>

<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  You can also fill out our contact form, and we’ll get back to you as soon as possible!

  <form action="" method="post" class="mt-10 flex flex-col lg:grid grid-cols-[200px_1fr] gap-x-5 lg:gap-y-5 text-xl">
    <label class="text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="title">Title *</label>
    <input type="text" required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="title" name="title">
    <label class="mt-5 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="content">Content *</label>
    <textarea required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="content" name="content"></textarea>
    <div></div>
    <div class="mt-5 lg:mt-0 flex items-center justify-start lg:none">
      <input type="submit" value="SEND" class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors">
    </div>
  </form>

  <script>
    $(document).ready(function() {
      const form = $("form[action='']");

      const validations = {
        title: {
          validate: function(value) {
            return value.length >= 3 && value.length <= 100;
          },
          errorMessage: "Title must be between 3 and 100 characters"
        },
        content: {
          validate: function(value) {
            return value.length >= 10 && value.length <= 1000;
          },
          errorMessage: "Content must be between 10 and 1000 characters"
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

        if (!isValid) {
          event.preventDefault();
        }
      });

      Object.keys(validations).forEach(function(field) {
        $("#" + field).on("input blur", function() {
          validateField(field);
        });
      });
    });
  </script>
</section>

<section class="mt-10 bg-white mx-5 lg:mx-20 relative">
  <h2 class="p-5 text-xl text-white text-center bg-pink-500">Find Us on the Map</h2>
  <div id="map" class="flex items-center justify-center">
    <iframe src="https://maps.google.com/maps?q=<?php echo htmlspecialchars($data['latitude']); ?>,<?php echo htmlspecialchars($data['longitude']); ?>&hl=es;z=14&output=embed" class="w-[100%] min-h-[500px]"></iframe>
  </div>
</section>
