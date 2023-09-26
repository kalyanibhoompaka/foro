<?php

namespace Drupal\foro_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Provides a 'foromenu_categories' block.
 *
 * @Block(
 *   id = "foromenu_categories",
 *   admin_label = @Translation("foromenu_categories block"),
 *   category = @Translation("foromenu_categories block")
 * )
*/
class foromenu_categories extends BlockBase {

  /**
  * {@inheritdoc}
  */
  public function build() {
    $block = array();
    $menuEntries = array();
    $nodeTerms = array();
    $path = \Drupal::request()->getpathInfo();
    $arg  = explode('/',$path);
    $arg0 = $arg[1];
    $arg1 = $arg[2]?? '';
    $arg2 = $arg[3]?? '';
    $vocabularyName = 'categorias';
    // $vocabulary =  taxonomy_vocabulary_machine_name_load($vocabularyName);
    // $terms = taxonomy_get_tree($vocabulary->vid);
    $vocabulary = Vocabulary::load('categorias');
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vocabulary->id());
    // Is any node loaded?
    if ( $arg0 == 'node' && is_numeric($arg1) && is_null($arg2)) {
      if( $node = \Drupal::routeMatch()->getParameter('node') ){
        $vocabularyField = ($vocabularyName == 'categorias') ? 'field_perfil_idea' : "field_$vocabularyName";

        if( !$node->get($vocabularyField)->isEmpty()){
          foreach ($node->get($vocabularyField)->getValue() as $value) {
            $nodeTerms[] = $value['target_id'];
          }
        }

      }
    }

    // Are we listing one taxonomy term
    if( $arg1 == 'categorias' && !empty($arg2) ){
      $pat = '/'.$arg1.'/'.$arg2;
      $alias = \Drupal::service('path_alias.manager')->getPathByAlias($pat);
      if (strcmp($alias, $path) == 0) {
        $alias = '';  // No alias was found.
      }
      $realpath = $alias; //drupal_lookup_path('source', "$arg1/$arg2");
      $parts = explode('/', $realpath);
      if( !empty($parts[2]) && is_numeric($parts[2]) ) $nodeTerms[] = $parts[2];
    }
    else if( $arg0 == 'taxonomy' && $arg1 == 'term' && is_numeric($arg2) && is_null( $arg[4] ) ){
      $nodeTerms[] = $arg2;
    }

    // Special cases: Ideas & Proyectos (only in "categorías" menu)
    $urlPrefix = '';
    if( $vocabularyName == 'categorias' ){
      $current_path = \Drupal::service('path.current')->getPath();
      $current_path = explode( '/' , \Drupal::service('path_alias.manager')->getAliasByPath($current_path) );
      if( ($current_path[0] == 'ideas' || $current_path[0] == 'proyectos') ){
        $urlPrefix = $current_path[0] . '/';
      }
    }

    foreach ($terms as $key => $term) {
      $menuEntries[] = array(
        'url' => \Drupal::request()->getSchemeAndHttpHost()."/".$urlPrefix.\Drupal::service('path_alias.manager')->getAliasByPath( "taxonomy/term/$term->tid" ),
        'title' => $term->name,
        'class' => in_array($term->tid, $nodeTerms)? 'selected': ''
      );
    }
    $title = ucfirst($vocabularyName);
    if( $vocabularyName == 'categorias' )$title = 'Categorías';
    $block[] = [
      '#theme' => 'foro_menu',
      '#entries' => $menuEntries,
      '#menuId'=> "menu-$vocabularyName",
      '#title' => $title,
    ];
    return $block;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}