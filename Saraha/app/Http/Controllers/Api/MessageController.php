<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Traits\ResponseTrait;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{
    use ResponseTrait;
    public function store(Request $request,$id){
        $user=User::find($id);
        if(is_null($user)){
            return $this->returnError('this user not found',404);
        }

            $validator=Validator::make($request->all(),[
            'content' => 'required|min:3|string'
            ]);

        if($validator->fails()){
            return $this->returnError($validator->errors()->tojson(),400);
        };

        try {
            Message::create([

                'user_id' => $id,
                'content' => $request->input('content'),
            ]);
            return $this->returnSuccess('تم الارسال بنجاح',201);

        }
        catch (\Exception $exception){
            // dd($exception->getMessage());
            return $this->returnError('حدث خطأ ما',500);

        }

    }
}
