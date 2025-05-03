<?php if ($data['about']) { ?>
<form method="POST" class="space-y-4">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['about']->id); ?>">
  
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($data['about']->title); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
  </div>

  <div>
    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
    <textarea name="content" id="content" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><?php echo htmlspecialchars($data['about']->content); ?></textarea>
  </div>

  <div>
    <label for="imageUrl" class="block text-sm font-medium text-gray-700">Image URL</label>
    <input type="text" name="imageUrl" id="imageUrl" value="<?php echo htmlspecialchars($data['about']->imageUrl); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
  </div>

  <div>
    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
      Save Changes
    </button>
  </div>
</form>
<?php } ?> 