<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 20/03/2019
 * Time: 11:26
 */

namespace Drupal\hello\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;

class UserStatController extends ControllerBase
{


  public function content(UserInterface $user)
  {
    $query = \Drupal::database()->select('hello_user_statistics', 't')
      ->fields('t', array('action', 'time'))
      ->condition('uid',$user->id(),'=')->execute();


    $rows = [];
    $connexions = 0;
    foreach($query as $record){
      $rows [] = [
        $record->action == '1' ? $this->t('Login') : $this->t('Logout'),
        \Drupal::service('date.formatter')->format($record->time),
      ];
      $connexions = $connexions + $record->action;
    };
    $data = [
      'user' => $user,
      'count' => $connexions
    ];
    $message =  [
      '#theme' => 'hello-user-connexion',
      '#user' => $user,
      '#count' => $connexions
    ];
    $table = [
      '#type'=> 'table',
      '#header'=> [$this->t('Action'), $this->t('Time')],
      '#rows'=> $rows,
    ];


    return [
      'message' => $message,
      'table' => $table,

    ];


  }
}
