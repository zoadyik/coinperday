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

            $text_ex = explode(" ", $messages);

            if ($text_ex[0] == "protopool") {
                $json = (file_get_contents('https://protopool.net/api/wallet?address=' . rawurlencode($text_ex[1])));
                $json = str_replace('"unsold":', ' "unsold": ""', $json);
                $obj  = json_decode($json);

                if (empty($obj)) {
                    $result_text = "no data";
                } else {
                    $result_text = "currency : " . $obj->currency . "\nbalance : " . $obj->balance . "\nunpaid : " . $obj->unpaid . "\npaid 24 hr : " . $obj->paid24h . "\ntotal : " . $obj->total;
                }

                echo $result_text;
            } else {
                $result_text = "no data";
            }
            // Build message to reply back
            $messages = [
                'type' => 'text',
                'text' => $result_text,
            ];

            // Make a POST Request to Messaging API to reply to sender
            $url  = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages'   => [$messages],
            ];
            $post    = json_encode($data);
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
