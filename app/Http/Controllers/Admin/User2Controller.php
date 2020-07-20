<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Interfaces\Admin\CategoryRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class User2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $users = User::join("cities","cities.id","users.city_id")
            ->orderBy('id','desc')
            ->where("is_shop",0)
            ->select("users.id","users.name","users.phone","users.email","users.active",
                "users.suspend","cities.name_ar","cities.name_en","users.image")
            ->get();
        return view('cp.users.index',['users'=>$users]);

    }

    public function index2(){
        $users = User::join("shop_details","shop_details.shop_id","users.id")
            ->join("categories","categories.id","shop_details.category_id")
            ->join("cities","cities.id","users.city_id")
            ->orderBy('id','desc')
            ->where("is_shop",1)
            ->select("users.id","shop_details.name","users.phone","users.email","users.active",
                "users.suspend","cities.name_ar","cities.name_en","users.is_shop","shop_details.image",
                "business_id","tax_num","website","open_hours","open_from","open_to",
                "categories.name_en as cat_name_en","categories.name_ar as cat_name_ar")
            ->get();
        return view('cp.shops.index',['users'=>$users]);
    }

    public function indexAdmin(){
        $users = User::orderBy('id','desc')
            ->where("is_shop",3) //as admin
            ->select("users.id","users.name","users.email","users.suspend")
            ->get();
        return view('cp.admins.index',['users'=>$users]);
    }



    public function editClientStatus(Request $request,$id)
    {
        $cat=User::where("id",$id)->first();
        if($cat->suspend == 1){
            User::where("id",$id)
                ->update(["suspend" => 0 ]);
        }else{
            User::where("id",$id)
                ->update(["suspend" => 1 ]);
        }
        session()->flash('insert_message','تمت العملية بنجاح');
        return back();
    }

}
