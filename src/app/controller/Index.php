<?php
namespace Controller;
use Single\People as People;

class Index {

  public static function render() {
    $johnDoe1 = People::byName('John Doe');

    $provideName = function($SPC) {
      list($self, $params, $chain) = $SPC;
      try {
        $params['name'] = 'John Doe';
        $data = $chain->next([$self, $params, $chain]);
      } catch (Exception $e) {
        echo 'you caught something';
      }
    };

    $johnDoe1->applyFilter(['address', $provideName]);

    $johnDoe2 = People::byName('John Doe');

    echo $johnDoe2->address('New York, NY');
  }

}

