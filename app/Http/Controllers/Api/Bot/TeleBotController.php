<?php

namespace App\Http\Controllers\Api\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use WeStacks\TeleBot\Laravel\TeleBot;
use NotificationChannels\Telegram\TelegramUpdates;
class TeleBotController extends Controller
{
    //

    public function botInfo()
    {
      $bot = TeleBot::getMe();
      //TeleBot::bot('bot2')->getMe();

      return response()->json(['success'=>true,"Details"=>$bot]);
    }

    public function sendMessage(){
      $chatId = $this->getChadId();//store in user table instead of request every time
      $message = $this->getMessage();
      TeleBot::sendMessage([
          'chat_id' => $chatId,
          'text' => $message,
          'reply_markup' => [
              'inline_keyboard' => [[[
                  'text' => 'Google',
                  'url' => 'https://google.com/'
              ]]]
          ]
      ]);

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
          $chatId = $updates['result'][0]['my_chat_member']['chat']['id'];
          }

      //return response()->json(['success'=>true,"chatId"=>$chatId]);
      return $chatId;
    }

    public function getMessage(){
      $message = "Bug report\nOpen the document below";
      return $message;
    }
}
