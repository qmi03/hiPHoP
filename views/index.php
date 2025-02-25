<?php

function renderContentInLayout(string $layout, string $content): void {
  include($layout);
}

function renderView(string $view, array $data): void {
  ob_start();
  include($view);
  renderContentInLayout("views/layouts/applications.php", ob_get_clean());
  ob_flush();
}
