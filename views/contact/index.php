<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Have questions or need support? We're here to help!</h1>
</section>

<section class="bg-white mx-5 lg:mx-20 relative top-[-10px] text-lg md:flex items-center justify-between gap-5">
  <p class="flex-1/3 text-white bg-cyan-600 self-stretch p-10 text-xl font-bold text-center flex items-center justify-center">Our contact info</p>
  <ul class="flex-2/3 px-5 py-5 list-none md:mt-5 text-2xl">
    <li class="flex gap-2 underline text-cyan-600"><span>📧</span><a href="mailto:<?php echo htmlspecialchars($data['contact']['email']); ?>"><?php echo htmlspecialchars($data['contact']['email']); ?></a></li>
    <li class="mt-3 flex gap-2"><span>📞</span><a href="tel:<?php echo htmlspecialchars($data['contact']['phone']); ?>" class="underline text-cyan-600"><?php echo htmlspecialchars($data['contact']['phone']); ?></a></li>
    <li class="mt-3 flex gap-2"><span>📍</span><a href="#map" class="underline text-cyan-600"><?php echo htmlspecialchars($data['contact']['address']); ?></a></li>
  </ul>
</section>

<?php if ($_SESSION['isLoggedIn']): ?>
<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  You can also fill out our contact form, and we’ll get back to you as soon as possible!

  <form action="/contact" method="post" class="mt-10 flex flex-col lg:grid grid-cols-[200px_1fr] gap-x-5 lg:gap-y-5 text-xl">
    <label class="text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="title">Title *</label>
    <input type="text" required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="title" name="title">
    <label class="mt-5 text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="content">Content *</label>
    <textarea required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="message" name="message"></textarea>
    <div></div>
    <div class="mt-5 lg:mt-0 flex items-center justify-start lg:none">
      <input type="submit" value="SEND" class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors">
    </div>
  </form>

  <script>
    $(document).ready(function() {
      const form = $("form[action='/contact']");

      const validations = {
        title: {
          validate: function(value) {
            return value.length >= 3 && value.length <= 100;
          },
          errorMessage: "Title must be between 3 and 100 characters"
        },
        message: {
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

        if ($field.next().is("div") && $field.next().next().attr("id") === errorId) {
          $field.next().remove();
        }

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

<?php if ($data['messagesCount'] > 0): ?>
<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  <div>
  </div>

  <table class="w-full text-left">
    <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white ">
      Your messages
    </caption>
    <thead class="text-gray-700 uppercase bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-3">Title</th>
        <th scope="col" class="px-6 py-3">Created At</th>
        <th scope="col" class="px-6 py-3">Replied At</th>
        <th scope="col" class="px-6 py-3"></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data['paginatedMessages'] as $message): ?>
        <tr class="bg-white border-b border-gray-200">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
            <?= $message->title ?>
          </th>
          <td class="px-6 py-4">
            <?= $message->createdAt->format('Y-m-d H:i') ?>
          </td>
          <td class="px-6 py-4">
            <?= $message->respondedAt == null ? '-' : $message->respondedAt->format('Y-m-d H:i') ?>
          </td>
          <td class="px-6 py-4">
            <a
              href="/contact/messages?id=<?= $message->id ?>"
              class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
            >View</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <nav class="mt-5">
    <ul class="inline-flex -space-x-px text-base h-10">
      <li id="page-item-left">
        <?php if ($data['currentPage'] == 0): ?>
          <a class="flex items-center justify-center border border-gray-300 px-4 h-10 text-gray-400">Previous</a>
        <?php else: ?>
          <a
            class="flex items-center justify-center border border-gray-300 px-4 h-10 hover:text-pink-600 hove1"
            href="/contact?page=<?= $pageData['currentPage'] - 1 ?>"
          >Previous</a>
        <?php endif; ?>
      </li>
      <?php for ($i = $data['startPage']; $i <= $data['endPage']; $i++): ?>
        <li id="page-item-<?= $i ?>">
          <?php if ($i == $data['currentPage']): ?>
            <a
              class="flex items-center justify-center border border-gray-300 px-4 h-10 text-white bg-cyan-600">
              <?= $i + 1 ?>
            </a>
          <?php else: ?>
          <a
            class="flex items-center justify-center border border-gray-300 px-4 h-10 hover:text-pink-600 hove1"
            href="/contact?page=<?= $i ?>"
          >
            <?= $i + 1 ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endfor; ?>
      <li class="page-item-right">
        <?php if ($data['currentPage'] == $data['totalPages'] - 1): ?>
          <a class="flex items-center justify-center border border-gray-300 px-4 h-10 text-gray-400">Next</a>
        <?php else: ?>
          <a
            class="flex items-center justify-center border border-gray-300 px-4 h-10 hover:text-pink-600"
            href="/contact?page=<?= $pageData['currentPage'] + 1 ?>"
          >Next</a>
        <?php endif; ?>
      </li>
    </ul>
  </nav>
</section>
<?php endif; ?>

<?php endif; ?>

<section class="mt-10 bg-white mx-5 lg:mx-20 relative">
  <h2 class="p-5 text-xl text-white text-center bg-pink-500">Find Us on the Map</h2>
  <div id="map" class="flex items-center justify-center">
    <iframe src="https://maps.google.com/maps?q=<?php echo htmlspecialchars($data['contact']['latitude']); ?>,<?php echo htmlspecialchars($data['contact']['longitude']); ?>&hl=es;z=14&output=embed" class="w-[100%] min-h-[500px]"></iframe>
  </div>
</section>
