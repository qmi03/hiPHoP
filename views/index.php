<?php

function renderContentInLayout(string $layout, string $content, array $data): void
{
  include $layout;
}

function renderView(string $view, array $data): void
{
  ob_start();

  include $view;
  renderContentInLayout('views/layouts/default.php', ob_get_clean(), (new ContactModel())->fetch());
  ob_flush();
}

function renderAdminView(string $view, array $data): void
{
  ob_start();

  include $view;
  renderContentInLayout('views/layouts/admin.php', ob_get_clean(), ['user' => $GLOBALS['user']]);
  ob_flush();
}
