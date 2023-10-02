<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChatControler extends Controller
{
    //
    public function chat(){

        $users=User::all();

        return view('layouts.chat.chat',compact('users'));

    }

    public function chatForm($user_id){
        $recever =User::where('id',$user_id)->first();
        return view('layouts.chat.chat',compact('recever'));

    }
    public function sendMessage(Request $request ,$id){

        
        return response()->json('message send')
    }
}
