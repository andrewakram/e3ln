<?php

namespace App\Http\Controllers\Eloquent\User;

use App\Http\Controllers\Interfaces\User\AuthRepositoryInterface;
use App\Models\User;
use App\Models\Shop_detail;
use App\Models\Shop_categorie;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthRepository implements AuthRepositoryInterface {

    public function create($input)
    {
        $jwt = generateJWT();
        $array = array(
            'jwt' => $jwt,
            'name' => $input->name,
            'email' => $input->email,
            'phone' => $input->phone,
            'password' => Hash::make($input->password),
            'lat' => isset($input->lat)?$input->lat:0,
            'lng' => isset($input->lng)?$input->lng:0,
            'city_id' => $input->city_id,
            'is_shop' => $input->is_shop,
            'token' => $input->token,
            'active' => 0
        );

        if($user = User::create($array))
        {
            if($input->image) {
                $user->image = $input->image;
            }
            $this->sendSMS( 'activate', $user->phone);
            $user->save();
        }
        return $user->jwt;
        /************************/
        /*if($input->is_shop == 1){
            $array2 = array(
                'name' => $input->shop_name,
                'email' => $input->email,
                'description_en' => $input->description,
                'description_ar' => $input->description,
                'lat' => $input->lat,
                'lng' => $input->lng,
                'website' => $input->website,
                'tax_num' => $input->tax_num,
                'business_id' => $input->business_id,
                'open_hours' => $input->open_hours,
                'open_from' => $input->open_from,
                'open_to' => $input->open_to,
                'shop_id' => User::whereJwt($jwt)->select('id')->first()->id,
                'category_id' => $input->category_id,

            );

            if($user2 = Shop_detail::create($array2))
            {
                if($input->shop_image)
                {
                    $user2->image = $input->shop_image;
                }
                if($input->business_id)
                {
                    $user2->business_id = $input->business_id;
                }
                $user->save();

            }

        }
        return $user2;*/
    }

    public function beAShop($input,$email,$jwt,$lang)
    {
        User::where("email",$email)->update(['is_shop' => 1 ]);
        /************ Already a user then be a shop ************/
        if($input->is_shop == 1){
            $array2 = array(
                'name' => $input->shop_name,
                'email' => $email,
                'description_en' => $input->description,
                'description_ar' => $input->description,
                'lat' => $input->lat,
                'lng' => $input->lng,
                'website' => $input->website,
                'tax_num' => $input->tax_num,
                'business_id' => $input->business_id,
                'open_hours' => isset($input->open_hours)? $input->open_hours : null,
                'open_from' => isset($input->open_from)? $input->open_from : null,
                'open_to' => isset($input->open_to)? $input->open_to : null,
                'shop_id' => User::whereJwt($jwt)->select('id')->first()->id,
                'category_id' => $input->category_id,

            );

            if($user2 = Shop_detail::create($array2))
            {
                if($input->shop_image)
                {
                    $user2->image = $input->shop_image;
                }
                /*if($input->business_id)
                {
                    $user2->business_id = $input->business_id;
                }*/
                $user2->save();

            }
            /*update shop status*/
            User::where("email",$email)->update(['is_shop' => 1 ]);
        }
        return true;
    }






    /*public function assign_shop_categories($shop_id,$category_ids){
        foreach ($category_ids as $category_id){
            $Shop_categorie                 = new Shop_categorie();
            $Shop_categorie->shop_id        = $shop_id;
            $Shop_categorie->category_id    = $category_id;
            $Shop_categorie->save();
        }
    }*/

    public function sendSMS($type,$phone)
    {
        $activation_code = generateActivationCode();

        /*
        $message = "كود التفعيل الخاص بك هو".$activation_code;
        $message = urlencode($message);
        $url = "https://www.hisms.ws/api.php?send_sms&username=966563244763&password=Aa0563244763&message=$message&numbers=$phone&sender=JazApp&unicode=e&Rmduplicated=1&return=json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $decodedData = json_decode($data);
        */


        Verification::updateOrcreate
        (
            [
                'type' => $type,
                'phone' => $phone,
            ],
            [
                'code' => $activation_code,
                'expire_at' => Carbon::now()->addHour()->toDateTimeString()
            ]
        );
    }

    public function checkIfEmailExist($email)
    {
        return User::whereEmail($email)
            ->select('id','password','token','active','image','is_shop','jwt')->first();
    }

    public function checkIfPhoneExist($phone)
    {
        $user = User::wherePhone($phone)
            ->select('id','password','token','active','image','is_shop','jwt')->first();
        return $user;
    }

    public function checkIfEmailExist2($email,$id)
    {
        return User::whereEmail($email)
            ->where("id","!=",$id)
            ->select('id','password','token','active','image','is_shop','jwt')->first();
    }

    public function checkIfPhoneExist2($phone,$id)
    {
        $user = User::wherePhone($phone)
            ->where("id","!=",$id)
            ->select('id','password','token','active','image','is_shop','jwt')->first();
        return $user;
    }

    /*public function checkJWT($jwt)
    {
        return User::whereJwt($jwt)->select('id','password')->first();
    }*/

    public function checkId($id)
    {
        return User::whereId($id)->first();
    }

    public function codeCheck($code)
    {
        return Verification::whereCode($code)->first();
    }

    public function activeUser($phone)
    {
        $user = $this->checkIfPhoneExist($phone);
        $user->active = 1;
        $user->save();
        return $user;
    }

    public function userData($jwt,$is_shop,$lang)
    {
        global $user;
        if($is_shop == 1){
            $user=Shop_detail::join("users","users.id","shop_details.shop_id")
                ->where("jwt",$jwt)
                ->select("shop_id as id","users.jwt","shop_details.name", "users.email", "users.phone",
                    "business_id", "tax_num","shop_details.lat","shop_details.lng","users.city_id",
                    "description_".$lang." as description","users.active","users.is_shop",
                    "website","open_hours","open_from","open_to","users.image","users.token")
                ->first();
        }
        if($is_shop == 0){ /*update user data*/
            $user = User::where("jwt",$jwt)->first();
            $user->business_id = "";
            $user->tax_num = "";
            $user->description = "";
            $user->website = "";
            $user->open_hours = "";
            $user->open_from = "";
            $user->open_to = "";

        }
        //$user = User::whereJwt($jwt)->select('id','jwt','name','email','phone','lat','lng','image')->first();
        return $user ;
    }

    public function updateEmail($id,$is_shop,$input,$lang){
        if($input->is_shop == 1) { /*update shop additional data*/
            Shop_detail::where('shop_id', $id)
                ->update(['email' => $input->email]);
            User::where('id', $id)
                ->update(['email' => $input->email]);
            /*$user->update(['email' => $input->email]);
            $user2 = User::where('id', $id)->first();
            $user2->update(['email' => $input->email]);*/
        }
        if($input->is_shop == 0) { /*update user data*/
            User::where('id', $id)
                ->update(['email' => $input->email]);
        }
        $user2 = User::where('id', $id)->first();
        return $this->userData($user2->jwt,$is_shop,$lang);
    }

    public function updatePhone($id,$is_shop,$input,$lang){
        if($input->is_shop == 1) { /*update shop additional data*/
            /*Shop_detail::where('shop_id', $id)
                ->update(['phone' => $input->phone]);*/
            User::where('id', $id)
                ->update(['phone' => $input->phone]);
            /*$user = Shop_detail::where('shop_id', $id)->first();
            $user->update(['phone' => $input->phone]);
            $user2 = User::where('id', $id)->first();
            $user2->update(['phone' => $input->phone]);*/
        }
        if($input->is_shop == 0) { /*update user data*/
            /*$user2 = User::where('id', $id)->first();
            $user2->update(['phone' => $input->phone]);*/
            User::where('id', $id)
                ->update(['phone' => $input->phone]);
        }
        $user2 = User::where('id', $id)->first();
        return $this->userData($user2->jwt,$is_shop,$lang);
    }

    public function editeProfile($id,$input,$lang){
        if($input->is_shop == 1){ /*update shop additional data*/
            $startTime = Carbon::parse($input->open_from);
            $finishTime = Carbon::parse($input->open_to);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $x = (int)gmdate('H', $totalDuration);
            $x = $x."H" ;


            $user = Shop_detail::where('shop_id', $id)->first();

            if( $input->hasFile('image') ){
                $user->update([ "image"  => $input->image ]);
                $user->save();
            }
            $user->update($input->except(['email',
                'open_hour','open_from','open_to','image']));
            $user->update([
                'open_hours' => $input->open_hours == "" ? $x : $input->open_hours,
                'open_from' => $startTime,
                'open_to'   => $finishTime,
            ]);

            $user->save();


            $user=Shop_detail::join("users","users.id","shop_details.shop_id")
                ->where("shop_id",$id)
                ->select("shop_id as id","users.jwt","shop_details.name", "users.email", "users.phone",
                    "business_id", "tax_num","shop_details.lat","shop_details.lng","users.city_id",
                    "description_".$lang." as description","users.active","users.is_shop",
                    "website","open_hours","open_from","open_to","users.image","users.token")
                ->first();
        } /*End update shop additional data*/
        ////////
        ////////
        if($input->is_shop == 0){ /*update user data*/
            $user = User::where('id', $id)->first();
            $user->update($input->except(['email','phone']));
            $user->business_id = "";
            $user->tax_num = "";
            $user->description = "";
            $user->website = "";
            $user->open_hours = "";
            $user->open_from = "";
            $user->open_to = "";

        } /*End update user data*/
        //
        ////////
        ////////

        //return data
        return $user;
    }
}
