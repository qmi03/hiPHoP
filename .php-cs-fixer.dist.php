<?php

use PhpCsFixer\Config;
use Symfony\Component\Finder\Finder;

$finder = Finder::create()
  ->in(__DIR__) // Process files in the current directory (where .php-cs-fixer.dist.php is located)
  ->exclude([
    'node_modules',
    'tests/fixtures',
    'public',
  ])
;

return (new Config())
  ->setIndent('  ') // Two spaces for indentation
  ->setRules([
    '@PhpCsFixer' => true,
  ])
  ->setFinder($finder) // Attach the Finder configuration
;
