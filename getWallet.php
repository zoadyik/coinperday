<?php
require_once '../vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use \Statickidz\GoogleTranslate;

$logger = new Logger('LineBot');
$logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV["LINEBOT_ACCESS_TOKEN"]);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV["LINEBOT_CHANNEL_SECRET"]]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

try {
	$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
	error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
	error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
	error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
	error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}
foreach ($events as $event) {
	// Postback Event
	if (($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
		$logger->info('Postback message has come');
		continue;
	}
	// Location Event
	if  (($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage)) {
		$logger->info("location -> ".$event->getLatitude().",".$event->getLongitude());
		continue;
	}

  if  (($event instanceof \LINE\LINEBot\Event\MessageEvent\StickerMessage)) {
			// $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder();
     $logger->info("Sticker Id : ".$event->getStickerId());
     $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("Sticker Id : ".$event->getStickerId());
     $response = $bot->replyMessage($event->getReplyToken(), $outputText);
     continue;
  }
  if (($event instanceof \LINE\LINEBot\Event\MessageEvent\ImageMessage)) {
			// $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder();

     $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("This is a image");
     $response = $bot->replyMessage($event->getReplyToken(), $outputText);
     continue;
  }
	// Message Event = TextMessage
  if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
     $messageText=strtolower(trim($event->getText()));
     $text_ex= explode(" ", $messageText);

          if($text_ex[0] == "protopool")
          {
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_URL, 'https://protopool.net/api/wallet?address="'.rawurlencode($text_ex[1]));
            $result1 = curl_exec($ch1);
            curl_close($ch1);

            $obj = json_decode($result1, true);

            foreach($obj as $key => $val){

             $result_text = "currency : ".$val['currency']."\balance : ".$val['balance']."\unpaid : ".$val['unpaid']."\paid 24 hr : ".$val['paid24h']."\ntotal : ".$val['total'];

          }


          {

          

                        	// $response = $bot->replyMessage($event->getReplyToken(), $outputText);
 }



 $response = $bot->replyMessage($event->getReplyToken(), $outputText);

}


 // $ch1 = curl_init();
 //            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
 //            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
 //            // curl_setopt($ch1, CURLOPT_URL, 'https://a1234-df93d.firebaseio.com/data.json?orderBy="BRANCH_NAME"&startAt="สำนักงานใหญ่"&limitToFirst=1&print=pretty');
 //         curl_setopt($ch1, CURLOPT_URL, 'https://a1234-df93d.firebaseio.com/data.json?orderBy="BRANCH_NAME"&startAt="'.rawurlencode('สำนักงานใหญ่').'"&limitToFirst=10&print=pretty');


 //            $result1 = curl_exec($ch1);
 //            curl_close($ch1);

 //            $obj = json_decode($result1, true);

 //            // var_dump(obj);

 //               foreach($obj as $key => $val){
 //                // echo $key.' => '.$val['BRANCH_NAME']."\n";
 //                $result_text = $val['BRANCH_NAME'];
 //                echo $result_text." <BR>";
 //            }
