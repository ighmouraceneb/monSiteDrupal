<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 25/04/2019
 * Time: 15:39
 */

namespace Drupal\perf;


class LazyBuildersService
{
  public function page($userName){
    return [
      '#markup' => 'Your name is '. $userName,
    ];
  }

}
