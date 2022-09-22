<?php

namespace App\Http\Controllers\Api\Bot;

use App\Http\Controllers\Controller;
use App\Models\ChatId;
use Illuminate\Http\Request;
use WeStacks\TeleBot\Laravel\TeleBot;
use NotificationChannels\Telegram\TelegramUpdates;
use App\Models\Message;
class TeleBotController extends Controller
{
    //

    public function botInfo()
    {
      $bot = TeleBot::getMe();
      //TeleBot::bot('bot2')->getMe();

      return response()->json(['success'=>true,"Details"=>$bot]);
    }

    public function sendMessage(Request $request){
     // $chatId = $this->getChadId();//store in user table instead of request every time
    $this->getChadId();
      $chatIds = ChatId::all()->pluck('chat_id')->toArray();
      $uniqueIds = array_unique($chatIds);

      $text = $this->postMessage($request);
      foreach($uniqueIds as $chat_id){
        $message = $text;
        TeleBot::sendMessage([
            'chat_id' => $chat_id,
            'text' => $message,

        ]);
      }


    }

    public function getUpdates(){
      $updates = TeleBot::getUpdates();
      return response()->json(['success'=>true,"updates"=>$updates]);
    }

    public function getChadId(){
      $updates = TelegramUpdates::create()
          //->limit(1)
          ->options([
              'timeout' => 0,//if 0, i.e , short polling, only for testing
          ])
          ->get();

          if($updates['ok']) {
          $chatId = $updates['result'][0]['message']['chat']['id'];

          $chatIds = [];
          $results = $updates['result'];
          $result_count = sizeof($updates['result']);
          $chatId = ChatId::where('chat_id', $chatId)->first();


          for($i = 0; $i < $result_count; $i++){

            $chat_id = $updates['result'][$i]['message']['chat']['id'];

            $chatId = ChatId::where('chat_id', $chat_id)->pluck('chat_id');
           // dd($chatId);
            if($chatId){
                ChatId::create([
                    'chat_id' => $chat_id
                ]);
            }
            else{

            }

          }
          }
         // print_r($updates);
          //dd(sizeof($updates['result']));
      //return response()->json(['success'=>true,"chatId"=>$chatId]);
      return $chatId;
    }

    public function postMessage(Request $request){
        $data = $request->all();
        $message = $request->message;
        Message::create([
            'message' => $message
        ]);
        return $message;
    }

    public function getMessage(Request $request){
        $message = $request->message;

        return $message;
    }
}
