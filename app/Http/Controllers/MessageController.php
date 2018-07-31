<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Message;
use Illuminate\Http\Request;
use Validator;

class MessageController extends Controller
{
    /**
     * Apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Check if message belongs to user
     */
    public function belongsToUser(Message $message)
    {
        $user = Auth::user();
        return $message->user_id === $user->id;
    }

    /**
     * Display a listing of the resource in descending order
     * Paginate by 10
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = Message::with('user')
            ->orderByDesc('updated_at');

        if ($request->has('user_id')) {
            // Redirect if not owner
            $user_id = (int) $request->user_id;
            if (Auth::user()->id !== $user_id) {
                return redirect('messages')->withErrors('Unauthorized to view messages');
            }
            $messages->where('user_id', $user_id);
        }

        // Paginate the messages
        $messages = $messages->paginate(10);

        return view('messages.index')
            ->with('messages', $messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('messages/create')
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = Auth::user();
        $user->messages()->create([
            'content' => $request->content,
        ]);

        return redirect('/messages');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        // Redirect if not owner
        if (!$this->belongsToUser($message)) {
            return redirect('messages')->withErrors('Unauthorized to edit message');
        }

        return view('messages.edit')
            ->with('message', $message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        // Redirect if not owner
        if (!$this->belongsToUser($message)) {
            return redirect('messages')->withErrors('Unauthorized to edit message');
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('messages/' . $message->id . '/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        $message->content = $request->content;
        $message->save();

        return redirect('/messages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        // Redirect if not owner
        if (!$this->belongsToUser($message)) {
            return redirect('messages')->withErrors('Unauthorized to delete message');
        }

        $message->delete();

        return redirect('/messages')->with('status', 'Message deleted');
    }
}
