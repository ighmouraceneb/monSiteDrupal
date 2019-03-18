<?php


namespace Drupal\hello\Controller;


use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase
{
  public function content($param){
    $message =   $this->t('Votre nom est  :   %name et votre identifiant : @parm',
      [
        '%name'=>  $this->currentUser()->getAccountName() ? $this->currentUser()->getAccountName() : $this->t('guest'),
        '@parm'=> $param
      ]

    );
    $build = ['#markup'=>$message];
    return $build;

  }
}
