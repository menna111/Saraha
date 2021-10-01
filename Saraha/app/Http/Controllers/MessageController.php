<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function create($id){
        //هشوف id موجود ولا لا


        $user=User::findOrFail($id);
        $user->no_of_visits +=1;
        $user->save();
        if($id == Auth::id()){
            $isvalid = false;
            return view('create',compact('isvalid','user'));
        }else{
            $isvalid= true;
            return view('create',compact('isvalid','user'));
        }

    }



    public function store(Request $request,$id){
        $user=User::findOrFail($id);


        $request->validate([
           'content' => ['required','string','min:3']
        ]);
        try {
            Message::create([

                'user_id' => $id,
                'content' => $request->input('content'),
            ]);
            return redirect()->route('message.create',$id)->with('success','نم ارسال الرسالة بنجاح');

        }
        catch (\Exception $exception){
           // dd($exception->getMessage());
            return redirect()->route('message.create',$id)->with('error','حدث خطأ ما الرجاء المحاولة لاحقا');

        }

    }
}
