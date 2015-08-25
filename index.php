<?php
/**
  * wechat php test
  */
  
include dirname(__FILE__).'\\src\\WechatDeal\\WechatEventDeal.php';

//define your token
define("TOKEN", "weixin_baicai1987");
$wechatObj = new wcMobileLibraryInterface();
//$wechatObj->valid();

//receive the message
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}//end of if


$wechatObj->responseMsg();

class wcMobileLibraryInterface
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
//                 $keyword = trim($postObj->Content);
                $MsgType = $postObj->MsgType;
                $time = time();
                
                switch ($MsgType){
                	case "text":
                		$dealObj = new WechatEventDeal($postObj);
                		$dealObj->deal();
                		break;
                	case "event":
                		$dealObj = new WechatEventDeal($postObj);
                		$dealObj->deal();
                		break;
                }//end of switch
                
                
//                 $textTpl = "<xml>
// 							<ToUserName><![CDATA[%s]]></ToUserName>
// 							<FromUserName><![CDATA[%s]]></FromUserName>
// 							<CreateTime>%s</CreateTime>
// 							<MsgType><![CDATA[%s]]></MsgType>
// 							<Content><![CDATA[%s]]></Content>
// 							<FuncFlag>0</FuncFlag>
// 							</xml>";             
// // 				if(!empty( $keyword ))
// //                 {
//               		$msgType = "text";
//                 	$contentStr = "Welcome to wechat world!";
//                 	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                 	echo $resultStr;
//                 }else{
//                 	echo "Input something...";
//                 }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>