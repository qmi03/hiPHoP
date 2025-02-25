<?php
require_once("controllers/HomeController.php");

$routes = array(
  "/" => function() { (new HomeController())->index(); },
);
