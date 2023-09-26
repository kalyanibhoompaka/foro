<?php

namespace Drupal\popular_searches\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Database\Database;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\node\Entity\Node;

/**
 * Popular Search API route.
 */
class PopularSearchController extends ControllerBase {
  /**
   * Popular search data.
   */
  
  /**
   * Function to get the Node's Data.
   */
  public function getSearchData() {

    if (\Drupal::request()->query->has('id')) {

      $node_id = \Drupal::request()->query->get('id');

      if (isset($node_id)) {

        $node = Node::load($node_id);  
        $node_type = $node->bundle();       
        $node_title = $node->label();       
        $node_path =  $node->field_unique_url->value;
        
        $today_date = DrupalDateTime::createFromTimestamp(time());

        //Store the data entries of popular searches in last 3 days
        $conn = Database::getConnection();

        $conn->insert('popular_searches')->fields(
          array(
            'node_nid' => $node_id,
            'data_type' => $node_type,
            'title' => $node_title,
            'link_uri' => $node_path,
            'created_date' => $today_date->format('Y-m-d\TH:i:s'),
            'entry_date' => $today_date->format('Y-m-d'),
          )
        )->execute();

        return new JsonResponse('Popular Search Created.');
      }
      else {
        throw new NotFoundHttpException(t('There is no such content present in the website'));
      }
    }
  }
}
