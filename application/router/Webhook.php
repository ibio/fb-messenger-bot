<?php
namespace application\router;
use org\weemvc\core\Router;
use org\weemvc\Pager;

class Webhook extends Router{

  public function portal($get, $post){
    $result = null;
    // Pager::log($_SERVER['REQUEST_METHOD'], 'app.log');
    // $this->_controller->prepareDatabase();
    // http://stackoverflow.com/questions/359047/detecting-request-type-in-php-get-post-put-or-delete
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
      $result = $this->get($get);
    }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
      // http://stackoverflow.com/questions/35917132/facebook-sends-empty-post-to-a-webhook
      // for Facebook special POST
      $result = $this->post(file_get_contents('php://input'));
    }
    echo $result;
  }

  public function test($get, $post){
    // delutter
    if($get['case'] === 'postback'){
      $source = '{"object":"page","entry":[{"id":"887512484683306","time":1480299846663,"messaging":[{"recipient":{"id":"887512484683306"},"timestamp":1480299846663,"sender":{"id":"1409456102405558"},"postback":{"payload":"' . $get['payload'] . '"}}]}]}';
      // echo $source;
      $this->post($source);
    }else if($get['case'] === 'message'){
      $source = '{"object":"page","entry":[{"id":"887512484683306","time":1480292711303,"messaging":[{"sender":{"id":"1409456102405558"},"recipient":{"id":"887512484683306"},"timestamp":1480292711254,"message":{"mid":"mid.1480292711254:150fb22f91","seq":13,"text":"' . $get['text'] . '"}}]}]}';
      $this->post($source);
    }
    
  }

  // for validation
  protected function get($get){
    $str = '';
    // Pager::log($data, 'app.log');
    // http://stackoverflow.com/questions/68651/get-php-to-stop-replacing-characters-in-get-or-post-arrays
    // NOTICE: php change . -> _ automatically
    if($get['hub_verify_token'] === UPPER_SERVICE_TOKEN) {
      $str = $get['hub_challenge'];
    }
    return $str;
  }

  protected function post($source){
    // http://php.net/manual/en/function.json-decode.php
    $data = json_decode($source, true);
    Pager::log($source, 'app.log');

    // Make sure this is a page subscription
    if ($data['object'] === 'page') {
      // Iterate over each entry
      // There may be multiple if batched
      foreach ($data['entry'] as $page){
        $pageID = $page['id'];
        $timeOfEvent = $page['time'];

        // Iterate over each messaging event
        foreach ($page['messaging'] as $messaging){

          if(isset($messaging['optin'])) {
            // receivedAuthentication($messaging);
          }else if(isset($messaging['message'])) {
            $text = $messaging['message']['text'];
            // for quick reply messages
            if(isset($messaging['message']['quick_reply'])){
              $text = $messaging['message']['quick_reply']['payload'];
            }
            $param = array(
              'id' => $messaging['sender']['id'],
              'text' => $text, 
            );
            $this->_controller->sendWee('InterpretMessage', $param);
            // receivedMessage($messaging);
          }else if(isset($messaging['delivery'])) {
            // receivedDeliveryConfirmation($messaging);
          }else if(isset($messaging['postback'])) {
            $param = array(
              'id' => $messaging['sender']['id'],
              'text' => $messaging['postback']['payload'], 
            );
            $this->_controller->sendWee('InterpretMessage', $param);
            // Pager::log(json_encode($messaging), 'app.log');
            // receivedPostback($messaging);
          }else if(isset($messaging['read'])) {
            // receivedMessageRead($messaging);
          }else if(isset($messaging['account_linking'])) {
            // receivedAccountLink($messaging);
          }else{
            // console.log("Webhook received unknown messagingEvent: ", messagingEvent);
          }
        }
      }
    }
    return null;
  }

}
