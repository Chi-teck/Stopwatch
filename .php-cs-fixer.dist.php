<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
  ->in(__DIR__ . '/src');

$rules = [
  '@PSR12' => true,
  'braces_position' => false,
];

return (new PhpCsFixer\Config())
  ->setRules($rules)
  ->setFinder($finder);
