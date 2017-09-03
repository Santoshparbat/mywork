<?php
/**
 * @file
 * Contains \Drupal\page_json\Controller\PageJson.
 */
namespace Drupal\axcelerent\Controller;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Controller\ControllerBase;
class PageJson extends ControllerBase {
  public function content() {
	 $current_path = \Drupal::service('path.current')->getPath();
     $path_args = explode('/', $current_path);
	 $page =  \Drupal\node\Entity\Node::load($path_args[2]);
	 $apikey = \Drupal::state()->get('siteapikey');
	 if($apikey != '1234'){
		 $data = array(0 => 'access denied'); 
	 }
	 elseif(is_object($page)){
		 if($page->getType() != 'page'){
		   $data = array(0 => 'access denied'); 
		 }else{
		   $data['title'] = $page->getTitle();
		   $body = $page->get('body')->getValue();
		   $data['body'] = $body[0]['value'];
	     }
	 }else{
	   $data = array(0 => 'access denied');
	 }
	 
	$response = new Response();
	$response->setContent(json_encode($data));
	$response->headers->set('Content-Type', 'application/json');
   return $response;
  }
}