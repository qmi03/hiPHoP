<?php if ($data['about']) { ?>
<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center"><?php echo htmlspecialchars($data['about']->title); ?></h1>
</section>

<section class="bg-white mx-5 lg:mx-20 relative top-[-10px] text-lg">
  <div class="md:flex gap-8 items-start p-10">
    <?php if ($data['about']->imageUrl) { ?>
      <div class="md:w-1/2 mb-8 md:mb-0">
        <img src="<?php echo htmlspecialchars($data['about']->imageUrl); ?>" alt="About Image" class="w-full h-auto rounded-lg shadow-lg">
      </div>
    <?php } ?>
    <div class="md:w-1/2">
      <div class="prose max-w-none">
        <?php echo nl2br(htmlspecialchars($data['about']->content)); ?>
      </div>
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

<section class="mt-12 mb-12">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="flex flex-col items-center text-center p-4">
      <div class="bg-pink-600 text-white rounded-full p-6 text-4xl shadow mb-4">🎯</div>
      <h3 class="text-2xl font-bold mb-2 text-pink-600">Our Mission</h3>
      <p class="text-lg text-gray-700">To provide exceptional services and create lasting relationships with our customers.</p>
    </div>
    <div class="flex flex-col items-center text-center p-4">
      <div class="bg-cyan-600 text-white rounded-full p-6 text-4xl shadow mb-4">🚀</div>
      <h3 class="text-2xl font-bold mb-2 text-cyan-700">Our Vision</h3>
      <p class="text-lg text-gray-700">To become the leading provider in our industry through innovation and excellence.</p>
    </div>
    <div class="flex flex-col items-center text-center p-4">
      <div class="bg-pink-500 text-white rounded-full p-6 text-4xl shadow mb-4">🤝</div>
      <h3 class="text-2xl font-bold mb-2 text-pink-600">Our Values</h3>
      <p class="text-lg text-gray-700">Quality, Innovation, Customer Focus, and Integrity in everything we do.</p>
    </div>
  </div>
</section>


<?php } ?> 