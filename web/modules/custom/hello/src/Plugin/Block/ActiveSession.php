<?php
/**
 * Created by PhpStorm.
 * User: Stagiaire
 * Date: 19/03/2019
 * Time: 11:54
 */

namespace Drupal\hello\Plugin\Block;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a activeSession block.
 *
 * @Block(
 *  id = "activeSession_block",
 *  admin_label = @Translation("Nombre de sessions!")
 * )
 */
class ActiveSession extends BlockBase
{
  /**
   * Implements Drupal\Core\Block\BlockBase::build().
   */
  public function build()
  {
    $database = \Drupal::database();

    $sessionActive = $database->select('sessions')->countQuery()->execute()->fetchField();
    $build = [
      '#markup' => $this->t('Actuellement il y a  @sessionActive session active', [
        '@sessionActive' => $sessionActive,

      ]),
      '#cache'=>[
        'key' => ['activeSession:block'],
        'contexts' => ['user'],
        'max-age' => '10',
      ],
    ];

    return $build;
  }

  protected function blockAccess(AccountInterface $account ) {
    return AccessResult::allowedIfHasPermission($account, 'access hello');
  }
}
