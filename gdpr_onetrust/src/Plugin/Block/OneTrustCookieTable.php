<?php

namespace Drupal\gdpr_onetrust\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Onetrust' Block.
 *
 * @Block(
 *   id = "onetrust_header",
 *   admin_label = @Translation("One Trust Cookie Table"),
 *   category = @Translation("GDPR Onetrust"),
 * )
 */
class OneTrustCookieTable extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $gdpr_config = \Drupal::config('gdpr_onetrust.settings');
    $gdpr_onetrust_version = $gdpr_config->get('gdpr_onetrust_version');
    if ($gdpr_onetrust_version == 2) {
      $markup = '<div id="ot-sdk-cookie-policy"></div>';
    }
    else {
      $markup = '<div id="optanon-cookie-policy"></div>';
    }
    
    $build = [];
    $build['#template'] = $markup;
    $build['#type'] = 'inline_template';
    $build['#cache'] = ['max-age' => 0];
    
    return $build;
  }

}
