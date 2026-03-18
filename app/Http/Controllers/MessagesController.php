<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessagesController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create($data);

        return redirect()->back()->with('toast_success', 'Your message has been sent.');
    }

    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        if (request()->ajax()) {
            return response()->json([
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject ?? 'No Subject',
                'message' => $message->message,
                'received' => $message->created_at->format('M d, Y h:i A'),
                'received_human' => $message->created_at->diffForHumans(),
            ]);
        }

        return view('messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();
        
        // Ensure this matches the name in web.php: admin.messages.index
        return redirect()->route('admin.messages.index')
            ->with('toast_success', 'Message deleted successfully.');
    }
}