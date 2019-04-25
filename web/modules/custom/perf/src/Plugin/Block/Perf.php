<?php


namespace Drupal\perf\Plugin\Block;


use Drupal\Core\Block\BlockBase;


/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "perf_block",
 *  admin_label = @Translation("Perf!")
 * )
 */
class Perf extends BlockBase
{

  public function build() {
    return [
      '#create_placeholder' => TRUE,
      '#lazy_builder' => [
        'perf.lazy_builders:page',
        [\Drupal::currentUser()->getAccountName()],
      ],
    ];
  }

}
