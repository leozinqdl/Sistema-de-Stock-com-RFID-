<?php
class Telegram
{
    function msnTelegramBotSend($chatID, $messaggio, $token)
    {
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url .= "&text=" . urlencode($messaggio);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); //para nao ficar aparecendo mensagem na tela
        curl_exec($ch);
        curl_close($ch);
    }
}