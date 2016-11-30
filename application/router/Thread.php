<?php
namespace application\router;
use org\weemvc\core\Router;
use org\weemvc\util\NetUtil;
use org\weemvc\Pager;

class Thread extends Router{
  private $_baseUrl = 'https://graph.facebook.com/v2.6/me/thread_settings?access_token=';

  // set up greeting, ONLY for the first time
  // https://developers.facebook.com/docs/messenger-platform/thread-settings/greeting-text
  public function greet($get, $post){
    // $this->_controller->prepareDatabase();
    $params = array(
      'setting_type' => 'greeting', 
      'greeting' => array('text' => "Dear {{user_first_name}}, welcome to this bot. $get[text]"),
    );
    $url = $this->_baseUrl . UPPER_SERVICE_TOKEN;
    $result = NetUtil::curlRequest($url, $params, 'POST', true);
    echo $result;
  }

  public function removeGreeting($get, $post){
    $params = array(
      'setting_type' => 'greeting', 
    );
    $url = $this->_baseUrl . UPPER_SERVICE_TOKEN;
    $result = NetUtil::curlRequest($url, $params, 'DELETE', true);
    echo $result;
  }

  public function getStarted($get, $post){
    // $this->_controller->prepareDatabase();
    $payload = array('payload' => 'get-started');
    $params = array(
      'setting_type' => 'call_to_actions', 
      'thread_state' => 'new_thread', 
      'call_to_actions' => array($payload),
    );
    $url = $this->_baseUrl . UPPER_SERVICE_TOKEN;
    $result = NetUtil::curlRequest($url, $params, 'POST', true);
    echo $result;
  }
}
