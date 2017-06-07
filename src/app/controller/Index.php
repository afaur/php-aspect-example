<?php
namespace Controller;
use Single\People as People;

class Index {

  public static function render() {
    $johnDoe = People::byName('John Doe');
    $johnDoe->name('John Doe');
    $johnDoe->age(24);
    $johnDoe->location('Somewhere');
    $johnDoe->details();
  }

}

