<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class HomeController extends Controller
{
    use ResponseTrait;
    public function index(){
        $messages=Message::select('content')->get();
        return $this->returnData('this is all data',$messages);


    }
}
