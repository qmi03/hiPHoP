<?php if ($data['about']) { ?>
<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center"><?php echo htmlspecialchars($data['about']->title); ?></h1>
</section>

<section class="bg-white mx-5 lg:mx-20 relative top-[-10px] text-lg">
  <div class="p-10">
    <div class="prose max-w-none">
      <?php echo nl2br(htmlspecialchars($data['about']->content)); ?>
    </div>
  </div>
</section>

<section class="bg-white mx-5 lg:mx-20 p-10 relative text-lg">
  <h2 class="text-2xl font-bold text-pink-600 mb-6">Why Choose Us?</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="flex items-start gap-4">
      <div class="bg-pink-100 p-3 rounded-full">
        <span class="text-2xl">🌟</span>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-cyan-600">Expert Team</h3>
        <p>Our team consists of highly skilled professionals dedicated to delivering excellence.</p>
      </div>
    </div>
    <div class="flex items-start gap-4">
      <div class="bg-pink-100 p-3 rounded-full">
        <span class="text-2xl">💡</span>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-cyan-600">Innovation</h3>
        <p>We constantly innovate to provide cutting-edge solutions for our clients.</p>
      </div>
    </div>
    <div class="flex items-start gap-4">
      <div class="bg-pink-100 p-3 rounded-full">
        <span class="text-2xl">🤝</span>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-cyan-600">Customer Focus</h3>
        <p>Your satisfaction is our top priority, and we go the extra mile to ensure it.</p>
      </div>
    </div>
    <div class="flex items-start gap-4">
      <div class="bg-pink-100 p-3 rounded-full">
        <span class="text-2xl">🎯</span>
      </div>
      <div>
        <h3 class="text-xl font-semibold text-cyan-600">Results-Driven</h3>
        <p>We focus on delivering measurable results that drive your success.</p>
      </div>
    </div>
  </div>
</section>
<?php } ?>