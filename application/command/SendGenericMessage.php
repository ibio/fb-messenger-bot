<?php
namespace application\command;
use org\weemvc\util\NetUtil;
use org\weemvc\Pager;

class SendGenericMessage extends SendTextMessage{

  public function execute($data){
    $params = $this->generic($data['id'], $data['title'], $data['subtitle'], $data['buttons'], $data['image'], $data['jumpUrl']);
    // echo json_encode($params);
    $result = NetUtil::curlRequest($this->getBaseUrl(), $params, 'POST', true);
    echo $result;
  }

  private function generic($id, $title, $subtitle = null, $buttons = null, $image = null, $url = null){
    $elements = array();
    /*
    $button = array(
      "type":"web_url",
      "url":"https://petersfancybrownhats.com",
      "title":"View Website"
    );
    $button = array(
      "type":"postback",
      "title":"Start Chatting",
      "payload":"DEVELOPER_DEFINED_PAYLOAD"
    );
    */
    $element = array(
      'title' => $title,
      'subtitle' => $subtitle,
      'image_url' => $image,
      'item_url' => $url,
      'buttons' => $buttons,
    );
    array_push($elements, $element);
    $payload = array('template_type' => 'generic', 'elements' => $elements);
    $params = array(
      'recipient' => array('id' => $id), 
      'message' => array('attachment' => array('type' => 'template', 'payload' => $payload)),
    );
    return $params;
  }
}