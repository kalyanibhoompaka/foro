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
class PopularSearchDataController extends ControllerBase {
  /**
   * Popular search data.
   */
  public function popularSearch() {

    //Get the Database entries of popular searches in last 3 days
    $db = \Drupal::database();
    
    $query = $db->select('popular_searches', 'ps');
    $query->fields('ps', ['node_nid','title','link_uri']);
    $query->addExpression('COUNT (node_nid)', 'count');
    $query->groupBy('ps.node_nid');
    $query->groupBy('ps.title');
    $query->groupBy('ps.link_uri');
    $query->range(0, 5);
    $query->orderBy('count', 'DESC');
    $query->where('created_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)');
    $results = $query->execute()->fetchAll();

    $popular_search_data = [];
   
     foreach ($results as $key => $result) {
      $node_title = $result->title;
      $node_path = $result->link_uri; 
      $popular_search_data[] = [
        'node_id' => $result->node_nid,
        'node_title' => $node_title,
        'path' => $node_path,
        'count' => $result->count,
      ];
    }
    
    $num_deleted = $db->delete('popular_searches')->where('created_date < DATE_SUB(NOW(), INTERVAL 30 DAY)')->execute();

    if(!empty($popular_search_data)) {

    return new JsonResponse($popular_search_data);

    }else{
     return new JsonResponse( ['status' => 201, 'message' => 'No Result Found'] );
    }

  }

}
