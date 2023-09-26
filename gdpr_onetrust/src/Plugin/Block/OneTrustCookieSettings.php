<?php

namespace Drupal\gdpr_onetrust\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Onetrust' Block.
 *
 * @Block(
 *   id = "onetrust_footer",
 *   admin_label = @Translation("One Trust Cookie Settings"),
 *   category = @Translation("GDPR Onetrust"),
 * )
 */
class OneTrustCookieSettings extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $gdpr_config = \Drupal::config('gdpr_onetrust.settings');
    $gdpr_onetrust_version = $gdpr_config->get('gdpr_onetrust_version');
    if ($gdpr_onetrust_version == 2) {
      $markup = "<button id='ot-sdk-btn' class='ot-sdk-show-settings'>" . t('Cookie Settings') . "</button>";
    }
    else {
      $markup = "<a class='optanon-toggle-display'>" . t('Cookie Settings') . "</a>";
    }
    
    $build = [];
    $build['#template'] = $markup;
    $build['#type'] = 'inline_template';
    $build['#cache'] = ['max-age' => 0];
    
    return $build;
  }

}
