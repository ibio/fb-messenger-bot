<?php
namespace application\command;
use org\weemvc\util\NetUtil;
use org\weemvc\Pager;

class SendQuickReply extends SendTextMessage{

  public function execute($data){
    // $btn0 = array('content_type' => 'text', 'title' => 'Red', 'payload' => '');
    //
		$params = array(
			'recipient' => array('id' => $data['id']),
			'message' => array(
        'text' => $data['text'],
        'quick_replies' => $data['replyList'],  
        ),
		);

    // var_dump($params);

    $result = NetUtil::curlRequest($this->getBaseUrl(), $params, 'POST', true);
    echo $result;
  }
}