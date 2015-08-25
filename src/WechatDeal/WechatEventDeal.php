<?php 
class WechatEventDeal{
	
	private $eventObj;
	
	//构造函数
	public function __construct($postObj){
		$this->eventObj = clone $postObj;
	}//end of __construct
	
	
	/*
	 * FunName: deal
	 * Description:
	 * Date:20150817
	 */
	public function deal(){
// 		switch ($this->eventObj->Event){
// 			case "subscribe":
				$this->dealSubscribe();
// 				break;
// 		}//end of switch
	}//end of deal
	
	/*
	 * FunName : dealSubscribe
	 * Description :
	 * Date : 2015年8月17日
	 */
	 private function dealSubscribe(){
	 	$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
	 	$toUsername = $this->eventObj->ToUserName;
	 	$fromUsername = $this->eventObj->FromUserName;
 		$msgType = "text";
 		$time = time();
 		$contentStr = $this->eventObj->FromUserName;
 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
 		echo $resultStr;
	 }//end of dealSubscribe
}
?>