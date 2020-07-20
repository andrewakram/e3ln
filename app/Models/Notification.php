<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use Notifiable;


    protected $table = 'notifications';

    function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    public static function send($tokens, $title="hello" , $msg="helo msg" , $type=0,$id=0){
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification1 = [
            'title' => $title,
            'body' => $msg,
            'type' => $type,
            'id' => $id,
            'icon' => 'myIcon',
            'sound' => 'mySound'
        ];
        $extraNotificationData = ["message" => $notification1, "moredata" => 'dd'];
        $fcmNotification = [
            'to' => $tokens, //single token
            'data' => $extraNotificationData
        ];
        $headers = [
            'Authorization: key=' .'AAAAItPzVnk:APA91bFYw9ITNYzdYINoLH9coQ9E_jK9kuleXeTqHQifS05CJFBGEy83vCZbUYFvkcwxLc-62sZc7z8sf6jecs8__UjW38mXluzLQdY2A0Rs8g3kBpmnExPD_wXdvpGYfEBMFWHnasTt',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


}
