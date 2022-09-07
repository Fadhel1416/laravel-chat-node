<?php

namespace App\Http\Controllers;

use Request;
use PRedis;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Redis\Connections\PredisConnection;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendMessage()
    {
        $redis = PredisConnection::connection();
        
        $data = ['message' => ClientRequest::input('message'), 'user' => ClientRequest::input('user')];
        
        $redis->publish('message', json_encode($data));
        
        return response()->json(['success' => true]);
    }
}