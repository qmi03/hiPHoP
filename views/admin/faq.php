<form method="POST" class="space-y-4">
  <div class="space-y-4">
    <?php foreach ($data['faqs'] as $faq) { ?>
      <div class="border rounded-lg p-4 space-y-2">
        <input type="hidden" name="update[<?php echo htmlspecialchars($faq->id); ?>][id]" value="<?php echo htmlspecialchars($faq->id); ?>">
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Question</label>
          <input type="text" name="update[<?php echo htmlspecialchars($faq->id); ?>][question]" value="<?php echo htmlspecialchars($faq->question); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Answer</label>
          <textarea name="update[<?php echo htmlspecialchars($faq->id); ?>][answer]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><?php echo htmlspecialchars($faq->answer); ?></textarea>
        </div>

        <div class="flex justify-end">
          <button type="button" onclick="deleteFAQ('<?php echo htmlspecialchars($faq->id); ?>')" class="inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            Delete
          </button>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="border rounded-lg p-4 space-y-2">
    <h3 class="text-lg font-medium">Add New FAQ</h3>
    
    <div>
      <label class="block text-sm font-medium text-gray-700">Question</label>
      <input type="text" name="create[0][question]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Answer</label>
      <textarea name="create[0][answer]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
    </div>
  </div>

  <div>
    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
      Save Changes
    </button>
  </div>
</form>

<script>
function deleteFAQ(id) {
  if (confirm('Are you sure you want to delete this FAQ?')) {
    const form = document.querySelector('form');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete[]';
    input.value = id;
    form.appendChild(input);
    form.submit();
  }
}
</script> 