<?php

namespace App\Http\Controllers;

use App\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function create($id){
//        $user=Auth::user();
        $user=User::findOrFail($id);
       $messages=$user->messages;
//        dd($messages);
        return view('create',compact('user','messages'));
    }



    public function store(Request $request,$id){
        $user=User::findOrFail($id);
//        dd($user);
        $requestd=$request->all();

        $validatedata=$request->validate([
           'content' => ['required','min:3','string'],
        ]);

        \App\Models\Message::create([
           'user_id' => $id,
            'content' => $requestd['content'],
        ]);
        return redirect()->route('message.create',$id);
    }
}
