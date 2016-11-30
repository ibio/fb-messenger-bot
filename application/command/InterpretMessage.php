<?php
namespace application\command;
use org\weemvc\core\Command;

class InterpretMessage extends Command{

  public function execute($data){
		$params = array();
		$params['id'] = $data['id'];
		// var_dump($data);
  	// TODO: need RegExp to parse some more user text
    if($data['text'] === 'get-started'){
      $params['title'] = 'Do you need deluttering service or need material support?';
      // $params['subtitle'] = 'We\'ve got the right stuff for everyone.';
      $params['image'] = 'https://secure.ypseek.com/messenger/res/get-started.png';
      // $params['jumpUrl'] = 'http://caom061.github.io/';
      $params['buttons'] = array(
      	array('type' => 'postback', 'title' => 'Declutter', 'payload' => 'declutter'),
      	array('type' => 'postback', 'title' => 'Need Material', 'payload' => 'need-material'),
      	// array('type' => 'web_url', 'title' => 'About this bot', 'url' => 'https://petersfancybrownhats.com'),
     	);
     	$this->_controller->sendWee('SendGenericMessage', $params);
    }else if($data['text'] === 'declutter'){
    	$params['text'] = 'How many items do you have?';
      $btn0 = array('content_type' => 'text', 'title' => '1-15', 'payload' => 'd-item-1-15');
      $btn1 = array('content_type' => 'text', 'title' => '15-30', 'payload' => 'd-item-15-30');
      $btn2 = array('content_type' => 'text', 'title' => '30+', 'payload' => 'd-item-30-plus');
      $params['replyList'] = array($btn0, $btn1, $btn2);
    	$this->_controller->sendWee('SendQuickReply', $params);
    }else if($data['text'] === 'd-item-1-15'){
      $params['text'] = 'Please keep storing for more than 15 items, or leave me a message below.';
      $this->_controller->sendWee('SendTextMessage', $params);
    }else if($data['text'] === 'd-item-15-30' || $data['text'] === 'd-item-30-plus'){
      $a = '[A]Sat. 10am-12pm';
      $b = '[B]Sat. 2pm-4pm';
      $c = '[C]Sun. 10am-12pm';
      $d = '[D]Sun. 2pm-4pm';
      $e = '[E]More options';
      $params['text'] = "Please schedule a time that works for you: {$a}, {$b}, {$c}, {$d}, {$e}";
      $btn0 = array('content_type' => 'text', 'title' => 'A', 'payload' => 'd-stime-a');
      $btn1 = array('content_type' => 'text', 'title' => 'B', 'payload' => 'd-stime-b');
      $btn2 = array('content_type' => 'text', 'title' => 'C', 'payload' => 'd-stime-c');
      $btn3 = array('content_type' => 'text', 'title' => 'D', 'payload' => 'd-stime-d');
      $btn4 = array('content_type' => 'text', 'title' => 'E', 'payload' => 'd-stime-e');
      $params['replyList'] = array($btn0, $btn1, $btn2, $btn3, $btn4);
      $this->_controller->sendWee('SendQuickReply', $params);
    }else if($data['text'] === 'd-stime-a' || 
             $data['text'] === 'd-stime-b' || 
             $data['text'] === 'd-stime-c' || 
             $data['text'] === 'd-stime-d'){
      $params['text'] = 'Please provide your address, and end up with #0000. Eg: 123 45St. APT6, New York, NY 10011 #0000';
      $this->_controller->sendWee('SendTextMessage', $params);
    // http://php.net/manual/en/function.strrpos.php
    // NOTICE: be careful that !== 
    }else if(strrpos($data['text'], '#0000') !== false){
      $a = '[A]Call Me';
      $b = '[B]Ring Bell';
      $c = '[C]I Will Leave The Stuff Outside';
      $params['text'] = "How do you want us to get the stuff when we arrive? {$a}, {$b}, {$c}";
      $btn0 = array('content_type' => 'text', 'title' => 'A', 'payload' => 'd-pickup-a');
      $btn1 = array('content_type' => 'text', 'title' => 'B', 'payload' => 'd-pickup-b');
      $btn2 = array('content_type' => 'text', 'title' => 'C', 'payload' => 'd-pickup-c');
      $params['replyList'] = array($btn0, $btn1, $btn2);
      $this->_controller->sendWee('SendQuickReply', $params);
    }else if($data['text'] === 'd-pickup-a'){
      $params['text'] = 'Please provide your phone number, and end up with #0001. Eg: 123-456-7890 #0001';
      $this->_controller->sendWee('SendTextMessage', $params);
    }else if((strrpos($data['text'], '#0001') !== false) || (strrpos($data['text'], '#0002') !== false) || $data['text'] === 'd-pickup-b'){
      $params['text'] = 'Order Confirmed!';
      $this->_controller->sendWee('SendTextMessage', $params);
      //
      $a = 'Reschedule';
      $b = 'Change Address';
      $c = 'Change Phone Number';
      $d = 'Change the way we get your stuff';
      $e = 'Cancel order';
      $params['text'] = "If you need to ${a}, ${b}, ${c}, ${d}, ${e}, please reply [help] anytime.";
      $this->_controller->sendWee('SendTextMessage', $params);
    }else if($data['text'] === 'd-pickup-c'){
      $params['text'] = 'Please discribe the place where you will put your stuff, and end up with #0002. Eg: outside my door, within black fence #0002';
      $this->_controller->sendWee('SendTextMessage', $params);
    }else if(strtolower($data['text']) === 'help'){
      $a = '[A]Reschedule';
      $b = '[B]Change Address';
      $c = '[C]Change Phone Number';
      $d = '[D]Change the way we get your stuff';
      $e = '[E]Cancel order';
      $params['text'] = "${a}, ${b}, ${c}, ${d}, ${e}";
      //
    	$btn0 = array('content_type' => 'text', 'title' => 'A', 'payload' => 'd-item-15-30');
      $btn1 = array('content_type' => 'text', 'title' => 'B', 'payload' => 'd-stime-a');
      $btn2 = array('content_type' => 'text', 'title' => 'C', 'payload' => 'd-pickup-a');
      $btn3 = array('content_type' => 'text', 'title' => 'D', 'payload' => '#0000');
      $btn4 = array('content_type' => 'text', 'title' => 'E', 'payload' => 'd-cancel');
      $params['replyList'] = array($btn0, $btn1, $btn2, $btn3, $btn4);
      $this->_controller->sendWee('SendQuickReply', $params);
    }else if($data['text'] === 'd-cancel'){
      $params['text'] = 'Order canceling, we will let you know when it is canceled successfully! NOTICE: you may only cancel the order before 1 day.';
      $this->_controller->sendWee('SendTextMessage', $params);
    }
  }
}