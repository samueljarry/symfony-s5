<?php

namespace App\Service;
use Symfony\Component\String\Slugger\AsciiSlugger;

class Sluggify {
  public function generate(string $string): string {
    $slugger = new AsciiSlugger();
    return $slugger->slug($string);
  }
}