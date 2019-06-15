<?php

namespace Drupal\axelerant\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Config\ConfigFactoryInterface;


public function nodedata() {
	$json_array = array(
      'data' => array()
    );
	
	$api_key = \Drupal::config('axelerant.settings')->get('site_api_key');
	
	$nids = \Drupal::entityQuery('node')->condition('type','page')->execute();
    $nodes =  Node::loadMultiple($nids);
    foreach ($nodes as $node) {
      $json_array['data'][] = array(
        'type' => $node->get('type')->target_id,
        'id' => $node->get('nid')->value,
		'site_api_key' => $api_key,
        'attributes' => array(
          'title' =>  $node->get('title')->value,
          'content' => $node->get('body')->value,
        ),
      );
    }
    return new JsonResponse($json_array);
  }
}




