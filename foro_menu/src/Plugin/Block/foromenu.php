<?php

namespace Drupal\foro_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Provides a 'Custom' block.
 *
 * @Block(
 *   id = "foromenu_block",
 *   admin_label = @Translation(" foromenu Block"),
 *   category = @Translation("foromenu block")
 * )
 */
class foromenu extends BlockBase {

  /**
  * {@inheritdoc}
  */
  public function build() {
    $block = array();
    
    $current_path = \Drupal::service('path.current')->getPath();
    $path = \Drupal::service('path_alias.manager')->getAliasByPath($current_path);
    $sections = explode( '/' , \Drupal::service('path_alias.manager')->getAliasByPath($current_path) );
    
    if( $sections[1] == 'ediciones' && !empty($sections[2]) ){
      $year = $sections[2];
      $terms = taxonomy_term_load_multiple_by_name($year, "ediciones_foro");
      if(empty($terms)){
        $url = Url::fromUserInput("/ediciones");
        $response = new RedirectResponse($url->toString());
        $response->send();
      }else{
      $section = !empty( $sections[3] ) ? $sections[3] : null;
      $block = _foro_menu_get_content( $year, $section );
    }
    }
    
    return $block;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
