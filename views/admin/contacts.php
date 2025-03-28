<div class="page-heading">
  <h3>Contacts</h3>
</div>

<section class="section">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Information</h5>
    </div>
    <form method="POST" action="/admin/contact/contact-update=true" class="card-body items-stretch">
      <div class="mb-3">
        <label for="contact-address" class="form-label">Address *</label>
        <input type="text" id="contact-address" name="address" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['address']); ?>">
        <?php if ('contact-address' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact address must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-phone" class="form-label">Tel *</label>
        <input type="text" id="contact-phone" name="phone" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['phone']); ?>">
        <?php if ('contact-phone' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact tel must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-facebook" class="form-label">Facebook *</label>
        <input type="text" id="contact-facebook" name="facebook" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['facebook']); ?>">
        <?php if ('contact-facebook' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact facebook must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-github" class="form-label">Github *</label>
        <input type="text" id="contact-github" name="github" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['github']); ?>">
        <?php if ('contact-github' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact github must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-longitude" class="form-label">Longitude *</label>
        <input type="number" step="0.0001" id="contact-longitude" name="longitude" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['longitude']); ?>">
        <?php if ('contact-longitude' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact longitude must not be empty!</p>
        <?php } ?>
      </div>
      <div class="mb-3">
        <label for="contact-latitude" class="form-label">Latitude *</label>
        <input type="number" step="0.0001" id="contact-latitude" name="latitude" class="form-control" required value="<?php echo htmlspecialchars($data['contact']['latitude']); ?>">
        <?php if ('contact-latitude' == $data['invalidField']) { ?>
          <p class="text-sm text-red-600">Contact latitude must not be empty!</p>
        <?php } ?>
      </div>
      <button type="submit" class="btn btn-primary mb-3">Update</button>
    </form>
  </div>
</section>
