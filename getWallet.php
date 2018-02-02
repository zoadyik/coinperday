<?php
$access_token = 'bwmo+NkxJAkK+XoT9LzMlkNVNwXDOu9UwyTBYXNznwNlSbXhzUD5YibMk/vo/PixOSiitVdrAHL4kpXh+yGZI0P0eq3ZFQdn36cSiGqIX7yo19H8O5SbSaEAnTqo/dl0GoP3nbCcwdvC9x7RYgwA3QdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
  // Loop through each event
  foreach ($events['events'] as $event) {
    // Reply only when message sent is in 'text' format
    if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
      // Get text sent
      $text = $event['message']['text'];
      // Get replyToken
      $replyToken = $event['replyToken'];

      // Build message to reply back
      $messages = [
        'type' => 'text',
        'text' => $text
      ];
      $text_ex= explode(" ", $messages);

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

      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/reply';
      $data = [
        'replyToken' => $replyToken,
        'messages' => [$result_text],
      ];
      $post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n";
    }
  }
}
echo "OK";