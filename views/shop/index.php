<section class="bg-pink-600 p-10">
  <h1 class="italic text-white text-4xl text-center">Explore Our Musical Instruments</h1>
</section>

<section class="bg-white mx-5 lg:mx-20 p-10 relative top-[-10px]">
  <div class="mb-8">
    <p class="text-lg text-gray-600">Discover our collection of high-quality musical instruments for all skill levels.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($data['instruments'] as $instrument) { ?>
      <div class="bg-gray-100 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="relative h-48 mb-4">
          <img src="<?php echo htmlspecialchars($instrument->imgURL); ?>" 
               alt="<?php echo htmlspecialchars($instrument->title); ?>"
               class="w-full h-full object-cover rounded-t-lg">
          <?php if (0 === $instrument->stockQuantity) { ?>
            <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-sm">
              Out of Stock
            </span>
          <?php } ?>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-2">
          <?php echo htmlspecialchars($instrument->title); ?>
        </h3>
        
        <p class="text-gray-600 mb-2">
          Brand: <?php echo htmlspecialchars($instrument->brand); ?>
        </p>
        
        <p class="text-gray-600 mb-2">
          Type: <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $instrument->type->value))); ?>
        </p>
        
        <?php if ($instrument->description) { ?>
          <p class="text-gray-500 text-sm mb-4">
            <?php echo htmlspecialchars($instrument->description); ?>
          </p>
        <?php } ?>
        
        <div class="flex justify-between items-center">
          <span class="text-2xl font-semibold text-pink-600">
            $<?php echo number_format($instrument->price, 2); ?>
          </span>
          
          <div>
            <?php if ($instrument->stockQuantity > 0) { ?>
              <span class="text-green-600 text-sm mr-2">
                <?php echo $instrument->stockQuantity; ?> in stock
              </span>
              <button class="bg-cyan-600 text-white px-4 py-2 rounded hover:bg-cyan-700 transition-colors">
                Add to Cart
              </button>
            <?php } else { ?>
              <span class="text-gray-500 text-sm italic">
                Currently unavailable
              </span>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <?php if (empty($data['instruments'])) { ?>
    <div class="text-center py-10">
      <p class="text-gray-600 text-lg">No instruments available at the moment.</p>
      <p class="text-gray-500">Check back later for new additions!</p>
    </div>
  <?php } ?>
</section>
