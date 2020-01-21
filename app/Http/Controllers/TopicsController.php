<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function index(Request $request,Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->with('user', 'category')->paginate(30);
        return view('topics.index', compact('topics'));
    }
}
