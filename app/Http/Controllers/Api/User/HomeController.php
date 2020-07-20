<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Interfaces\User\HomeRepositoryInterface;
use App\Http\Requests\LangRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $homeRepository;
    public function __construct(Request $request,HomeRepositoryInterface $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function countries(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $countries = $this->homeRepository->countries($request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$countries));
    }

    public function govsAndCities(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $govs = $this->homeRepository->govsAndCities($request,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$govs));
    }

    public function category(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $cat = $this->homeRepository->category($request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$cat));
    }

    public function shopsOfCategory(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'cat_ids'       => 'required',
            'city_id'       => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $shops = $this->homeRepository->shopsOfCategory($request,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$shops));
    }

    public function shopDetails(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'shop_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $d=checkJWT($request->header('jwt'));
        !empty($d) ? $user=$d->id : $user="";
        $shop = $this->homeRepository->shopDetails($request,$user,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$shop));
    }

    public function followAndUnfollow(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'shop_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

        if($d=checkJWT($request->header('jwt'))) {
            $result=$this->homeRepository->followAndUnfollow($d->id,$request,$request->header('lang'));

            if($result == false){
                return response()->json(msg($request,not_found(),'unfollowed'));
            }
            if($result == true){
                return response()->json(msg($request,success(),'success'));
            }
            if( $result == "blocked" ){
                return response()->json(msg($request,not_authoize(),'cant_follow'));
            }
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));


    }

    public function blockAndUnblock(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'user_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

        if($d=checkJWT($request->header('jwt'))) {
            $result = $this->homeRepository->blockAndUnblock($d->id,$request,$request->header('lang'));

            if($result == true){
                return response()->json(msg($request,success(),'success'));
            }
            if($result == false){
                return response()->json(msg($request,not_found(),'unblocked'));
            }
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));
        ////////////



        /*if($d=checkJWT($request->header('jwt'))) {
            $this->homeRepository->blockAndUnblock($d->id,$request,$request->header('lang'));
            return response()->json(msg($request,success(),'success'));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));*/


    }

    public function offerDetails(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'offer_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $offers = $this->homeRepository->offerDetails($request,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$offers));
    }

    public function getReviews(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'shop_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $reviews = $this->homeRepository->getReviews($request,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$reviews));
    }

    public function addReview(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'rate'      => 'required',
            'comment'   => 'required',
            'shop_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

        if($d=checkJWT($request->header('jwt'))) {
            $result=$this->homeRepository->addReview($d->id,$request,$request->header('lang'));
            if($result == false){
                return response()->json(msg($request,failed(),'cant_review'));
            }else{
                return response()->json(msg($request,success(),'success'));
            }
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));
    }

    public function deleteReview(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'review_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        if($d=checkJWT($request->header('jwt'))) {
            $this->homeRepository->deleteReview($request,$request->header('lang'));
            return response()->json(msg($request,success(),'success'));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function followingList(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $followingList = $this->homeRepository->followingList($d->id,$d->is_shop,$request->header('lang'));
            return response()->json(msgdata($request,success(),'success',$followingList));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));
    }

    public function blockingList(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $blockingList = $this->homeRepository->blockingList($d->id,$request->header('lang'));
            return response()->json(msgdata($request,success(),'success',$blockingList));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function addOffer(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $addedOffer = $this->homeRepository->addOffer($request,$d->id,$request->header('lang'));
            return response()->json(msgdata($request,success(),'success',$addedOffer));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function editOffer(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $editedOffer = $this->homeRepository->editOffer($request,$request->header('lang'));
            return response()->json(msgdata($request,success(),'success',$editedOffer));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));
    }

    public function deleteOffer(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $this->homeRepository->deleteOffer($request);
            return response()->json(msg($request,success(),'success'));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function deletePhone(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $this->homeRepository->deletePhone($request);
            return response()->json(msg($request,success(),'success'));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function phoneList(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $phones = $this->homeRepository->phoneList($d->id);
            return response()->json(msgdata($request,success(),'success',$phones));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function addPhone(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $phones = $this->homeRepository->addPhone($request,$d->id);
            return response()->json(msgdata($request,success(),'success',$phones));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }


    public function aboutUs(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $aboutUs = $this->homeRepository->aboutUs($request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$aboutUs));
    }

    public function terms(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $terms = $this->homeRepository->terms($request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$terms));
    }

    public function notifications(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        if($d=checkJWT($request->header('jwt'))) {
            $notifications = $this->homeRepository->notifications($d->id,$request->header('lang'));
            return response()->json(msgdata($request,success(),'success',$notifications));
        }
        return response()->json(msg($request,not_authoize(),'invalid_data'));

    }

    public function search(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        /* sortby [1 = nearest , 2 = rating , 3 = a-z ]*/

        $result = $this->homeRepository->search($request,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$result));
    }

    public function filterMinMaxPrices(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $result = $this->homeRepository->filterMinMaxPrices($request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$result));
    }

    public function searchByName(Request $request)
    {
        if(checkLang()!=null) return checkLang();

        $validator = Validator::make($request->all(),[
            'name'   => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $result = $this->homeRepository->searchByName($request,$request->header('lang'));

        return response()->json(msgdata($request,success(),'success',$result));
    }

}
