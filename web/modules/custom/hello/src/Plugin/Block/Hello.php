<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 18/03/2019
 * Time: 15:35
 */

namespace Drupal\hello\Plugin\Block;


use Drupal\Core\Block\BlockBase;


/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "hello_block",
 *  admin_label = @Translation("Hello!")
 * )
 */
class Hello extends BlockBase{
  /**
   * Implements Drupal\Core\Block\BlockBase::build().
   */
  public function build()
  {
    $name = \Drupal::currentUser()->getAccountName() ? \Drupal::currentUser()->getAccountName() : $this->t('guest');
    $build = [
      '#markup' => $this->t('Welcome @name. Tt is %time', [
        '@name' => $name,
        '%time' => \Drupal::service('date.formatter')->format(\Drupal::service('datetime.time')->getCurrentTime(), 'custom', 'H:i s\s'),
      ]),
    ];


    return $build;
  }
}
