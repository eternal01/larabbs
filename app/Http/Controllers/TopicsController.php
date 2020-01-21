<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Http\Requests\TopicRequest;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request,Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->with('user', 'category')->paginate(30);
        return view('topics.index', compact('topics'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
    }

    public function show(Topic $topic)
    {
        return view('topics.show',compact('topic'));
    }
}
