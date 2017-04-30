<?php 

ob_start();

$API_KEY = 'توکن';
##------------------------------##
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
 function sendmessage($chat_id, $text, $model){
	bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$mode
	]);
	}
	function sendaction($chat_id, $action){
	bot('sendchataction',[
	'chat_id'=>$chat_id,
	'action'=>$action
	]);
	}
	function Forward($KojaShe,$AzKoja,$KodomMSG)
{
    bot('ForwardMessage',[
        'chat_id'=>$KojaShe,
        'from_chat_id'=>$AzKoja,
        'message_id'=>$KodomMSG
    ]);
}
function sendphoto($chat_id, $photo, $action){
	bot('sendphoto',[
	'chat_id'=>$chat_id,
	'photo'=>$photo,
	'action'=>$action
	]);
	}
	//====================ᵗᶦᵏᵃᵖᵖ======================//
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$message_id = $update->message->id;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$text = $message->text;
$ali = file_get_contents("data/$from_id/ali.txt");
$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$message_id = $update->callback_query->message->message_id;
$ADMIN = ایدی عددی;
$fi = file_get_contents("data/$from_id/fi.txt");
//====================ᵗᶦᵏᵃᵖᵖ======================//
if($text == '/start'){

if (!file_exists("data/$from_id/ali.txt")) {
        mkdir("data/$from_id");
        file_put_contents("data/$from_id/ali.txt","none");
        $myfile2 = fopen("Member.txt", "a") or die("Unable to open file!");
        fwrite($myfile2, "$from_id\n");
        fclose($myfile2);
    }

sendaction($chat_id,'typing');
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"سلام من ربات فایل سازم میتونم براتون فایل بسازم با هرفرمتی وا خودتون بگید🙃",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'keyboard'=>[
	  	  [
	  ['text'=>"ساخت فایل"]
	  ]
		]
		])
  ]);
}
//====================ᵗᶦᵏᵃᵖᵖ======================//
//====================ᵗᶦᵏᵃᵖᵖ======================//
elseif($text == "/panel" && $chat_id == $ADMIN){
sendaction($chat_id, typing);
        bot('sendmessage', [
                'chat_id' =>$chat_id,
                'text' =>"ادمین عزیز به پنل مدیریتی ربات خودش امدید",
                'parse_mode'=>'html',
      'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>"آمار"],['text'=>"پیام همگانی"]
              ]
              ],'resize_keyboard'=>true
        ])
            ]);
        }
elseif($text == "آمار" && $chat_id == $ADMIN){
	sendaction($chat_id,'typing');
    $user = file_get_contents("Member.txt");
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
	sendmessage($chat_id , " آمار کاربران : $member_count" , "html");
}
elseif($text == "پیام همگانی" && $chat_id == $ADMIN){
    file_put_contents("ali.txt","bc");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>" پیام مورد نظر رو در قالب متن بفرستید:",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'/panel']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($ali == "bc" && $chat_id == $ADMIN){
    file_put_contents("ali.txt","none");
	SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>" پیام همگانی فرستاده شد.",
  ]);
	$all_member = fopen( "Member.txt", "r");
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
			SendMessage($user,$text,"html");
		}
}
//====================ᵗᶦᵏᵃᵖᵖ======================//
elseif ($text == "ساخت فایل") {
    file_put_contents("data/$from_id/ali.txt","fi1");
sendaction($chat_id,'typing');
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"خوب اول برام فرمتفایلتون را بگید  مثلا :\n  Rubix.txt یا Rubix.pdf یا ......",
  ]);
 }
elseif($ali == "fi1"){
    file_put_contents("data/$from_id/ali.txt","fi2");
    file_put_contents("data/$from_id/fi.txt",$text);
 sendaction($chat_id,'typing');
 bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"خوب حالا متن خودتون را برام بفرستید تا در فایل ذخیره کنمش و بعد براتون بفرستمش",
  ]);
}
elseif($ali == "fi2"){
    file_put_contents("data/$from_id/ali.txt","no");
    file_put_contents("$fi",$text);
 sendaction($chat_id,'upload_document');
 bot('senddocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$fi"),
  ]);
}
                    ?>