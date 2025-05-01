<section class="mt-10 bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  <div>
    Sent by <span class="font-bold"><?= $data['message']->username ?></span> at <span class="font-bold"><?= $data['message']->createdAt->format('Y-m-d H:i') ?></span>
  </div>
  <div>
    <textarea readonly disabled class="p-1 w-full h-36 mt-5 border text-gray-600 border-gray-300" id="message" name="message" rows="10" cols="50"><?= $data['message']->message ?></textarea>
  </div>
  <div class="border-t my-5 border-gray-300" />
  <?php if ($data['message']->respondedAt != null): ?>
    <div class="mt-5">
      Replied at <span class="font-bold"><?= $data['message']->respondedAt->format('Y-m-d H:i') ?></span>
    </div>
    <div>
      <textarea readonly disabled class="p-1 w-full h-36 mt-5 border text-gray-600 border-gray-300" id="message" name="message" rows="10" cols="50"><?= $data['message']->response ?></textarea>
    </div>
  <?php else: ?>
    <div class="mt-5">
      <span class="text-gray-500 italic">Not replied yet...</span>
    </div>
  <?php endif; ?>
</section>

<div class="m-5 lg:mx-20">
  <a
    href="/contact"
    class="cursor-pointer text-white text-lg font-bold px-3 py-2 bg-cyan-600 hover:bg-gray-500 transition-colors"
  >Back to Contact</a>
</div>
