<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 19/03/2019
 * Time: 13:39
 */

namespace Drupal\hello\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

class TestController extends ControllerBase
{
  public function content($nodetype = NULL){


    $node_types = $this->entityTypeManager()->getStorage('node_type')->loadMultiple();
    $type_items = [];
    foreach ($node_types as $node_type) {
      $url = new Url('hello.test', ['nodetype' => $node_type->id()]);
      $type_items[] = new Link($node_type->label(), $url);
    }

    $node_types_list = [
      '#theme' => 'item_list',
      '#items' => $type_items,
    ];

    $node_storage = $this->entityTypeManager()->getStorage('node');
    $query = $node_storage->getQuery();

    if($nodetype) {
      $query->condition('type', $nodetype);
    }
    $nids =  $query->pager(10)->execute();

    $nodes = $node_storage->loadMultiple($nids);

    $items = [];

    foreach ($nodes as $node) {
      $items[] = $node->toLink();
    };

    $pager = ['#type' => 'pager'];

    $list =  [
      '#theme' => 'item_list',
      '#items' => $items,
    ];

    return [
      'list' => $list,
      'pager' => $pager,
      'node_types_list' => $node_types_list,
      '#cache' => [
        'keys' =>['hello:node_list'],
        'tags' => ['node_list'],
        'contexts' => ['url'],
      ],
    ];


  }
}
