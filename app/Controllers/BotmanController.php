<?php

namespace App\Controllers;

use BotMan\BotMan\BotMan;

class BotmanController extends BaseController
{
    public function handle(){
        $this->botman->hears('/start', function (BotMan $bot) {
            $user = $bot->getUser();
            $bot->reply('Hello '.$user->getFirstName().' '.$user->getLastName());
            $bot->reply('Your username is: '.$user->getUsername());
            $bot->reply('Your ID is: '.$user->getId());
        });

        $this->botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself.');
        });

        $this->botman->listen();
    }

    public function setWebhook()
    {
        $url = "https://api.telegram.org/bot{$_ENV['API_TELE']}/setWebhook?url={$_ENV['app.baseURL']}/bot";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);

        var_dump(json_decode($result, true));
    }

    function tes()
    {
        $chtid = "780207093";
        return $this->sendMsgTele($chtid, "Halo yan..");
    }

}