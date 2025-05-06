<?php if (count($data['faqs'])) { ?>
<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Frequently Asked Questions</h1>
</section>

<section class="bg-white mx-5 lg:mx-20 relative top-[-10px] text-lg">
  <div class="p-10">
    <!-- Search Bar -->
    <div class="relative mb-8">
      <input 
        type="text" 
        id="faqSearch" 
        placeholder="Search for questions..." 
        class="w-full px-12 py-3 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-pink-300 border-2 border-pink-200 bg-white"
      >
    </div>

    <!-- Categories -->
    <div class="flex flex-wrap gap-2 mb-8">
      <button class="category-btn active px-4 py-2 rounded-full bg-pink-100 text-pink-600 hover:bg-pink-200 transition-colors" data-category="all">All</button>
      <?php 
      $categories = array_unique(array_column($data['faqs'], 'category'));
      foreach ($categories as $category) { ?>
        <button class="category-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors" data-category="<?php echo htmlspecialchars($category); ?>">
          <?php echo htmlspecialchars($category); ?>
        </button>
      <?php } ?>
    </div>

    <div class="grid grid-cols-1 gap-4" id="faqContainer">
      <?php foreach ($data['faqs'] as $index => $faq) { ?>
        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden transition-all duration-300" data-category="<?php echo htmlspecialchars($faq->category); ?>">
          <button 
            class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors"
            onclick="toggleFAQ(<?php echo $index; ?>)"
          >
            <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($faq->question); ?></h3>
            <svg id="faq-chevron-<?php echo $index; ?>" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="faq-answer-<?php echo $index; ?>" class="hidden">
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
              <p class="text-gray-600 whitespace-pre-line"><?php echo htmlspecialchars($faq->answer); ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<?php if ($data['isLoggedIn']): ?>
<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  <?php if (!empty($data['sent'])): ?>
    <div id="faq-success-alert" class="mb-5 p-4 rounded bg-green-100 text-green-800 border border-green-300">
      Gửi câu hỏi thành công!
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var textarea = document.getElementById('question');
        if (textarea) textarea.value = '';
      });
    </script>
  <?php endif; ?>
  <p class="mb-5">Can't find what you're looking for? Ask us directly!</p>

  <form action="/faq" method="post" class="mt-5 flex flex-col lg:grid grid-cols-[200px_1fr] gap-x-5 lg:gap-y-5 text-xl">
    <label class="text-left lg:text-right text-pink-600 lg:self-center cursor-pointer" for="question">Your Question *</label>
    <textarea required class="px-2 py-1 border-gray-300 border-2 rounded-sm focus:border-pink-200 shadow-gray shadow-sm text-lg italic" id="question" name="question" rows="4"></textarea>
    <div></div>
    <div class="mt-5 lg:mt-0 flex items-center justify-start lg:none">
      <input type="submit" value="SEND" class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors">
    </div>
  </form>

  <script>
    $(document).ready(function() {
      const form = $("form[action='/faq']");

      const validations = {
        question: {
          validate: function(value) {
            return value.length >= 10 && value.length <= 1000;
          },
          errorMessage: "Question must be between 10 and 1000 characters"
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

<?php if ($data['questionsCount'] > 0): ?>
<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  <table class="w-full text-left">
    <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white">
      Your Questions
    </caption>
    <thead class="text-gray-700 uppercase bg-gray-50">
      <tr>
        <th scope="col" class="px-6 py-3">Question</th>
        <th scope="col" class="px-6 py-3">Asked At</th>
        <th scope="col" class="px-6 py-3">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data['paginatedQuestions'] as $question): ?>
        <tr class="bg-white border-b border-gray-200">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900">
            <?= htmlspecialchars($question->content) ?>
          </th>
          <td class="px-6 py-4">
            <?= $question->createdAt->format('Y-m-d H:i') ?>
          </td>
          <td class="px-6 py-4">
            <?= $question->isAnswered ? 'Answered' : 'Pending' ?>
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
            class="flex items-center justify-center border border-gray-300 px-4 h-10 hover:text-pink-600"
            href="/faq?page=<?= $data['currentPage'] - 1 ?>"
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
            class="flex items-center justify-center border border-gray-300 px-4 h-10 hover:text-pink-600"
            href="/faq?page=<?= $i ?>"
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
            href="/faq?page=<?= $data['currentPage'] + 1 ?>"
          >Next</a>
        <?php endif; ?>
      </li>
    </ul>
  </nav>
</section>
<?php endif; ?>

<?php endif; ?>

<script>
function toggleFAQ(index) {
  const answer = document.getElementById(`faq-answer-${index}`);
  const chevron = document.getElementById(`faq-chevron-${index}`);
  
  if (answer.classList.contains('hidden')) {
    answer.classList.remove('hidden');
    chevron.classList.add('rotate-180');
  } else {
    answer.classList.add('hidden');
    chevron.classList.remove('rotate-180');
  }
}

// Search functionality
document.getElementById('faqSearch').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const faqItems = document.querySelectorAll('.faq-item');
  
  faqItems.forEach(item => {
    const question = item.querySelector('h3').textContent.toLowerCase();
    const answer = item.querySelector('p').textContent.toLowerCase();
    
    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
      item.style.display = '';
    } else {
      item.style.display = 'none';
    }
  });
});

// Category filtering
document.querySelectorAll('.category-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    // Update active state
    document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active', 'bg-pink-100', 'text-pink-600'));
    this.classList.add('active', 'bg-pink-100', 'text-pink-600');
    
    const category = this.dataset.category;
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
      if (category === 'all' || item.dataset.category === category) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });
});
</script>
<?php } ?>