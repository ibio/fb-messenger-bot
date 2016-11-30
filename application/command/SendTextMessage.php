<?php
namespace application\command;
use org\weemvc\core\Command;
use org\weemvc\util\NetUtil;
use org\weemvc\Pager;

class SendTextMessage extends Command{
	private $_baseUrl = 'https://graph.facebook.com/v2.6/me/messages?access_token=';

  public function execute($data){
		$params = array(
			'recipient' => array('id' => $data['id']),
			'message' => array('text' => $data['text']),
		);

    $result = NetUtil::curlRequest($this->getBaseUrl(), $params, 'POST', true);
    echo $result;
  }

  protected function getBaseUrl(){
  	$url = $this->_baseUrl . UPPER_SERVICE_TOKEN;
  	return $url;
  }
}