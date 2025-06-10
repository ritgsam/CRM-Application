<?php


namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use App\Models\Contact;
use App\Models\Meetings;
use Illuminate\Http\Request;


class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meetings::with('host', 'contact')->latest()->get();
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $users = User::all();
        $contacts = Contact::all();
        return view('meetings.create', compact('users', 'contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'venue' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'host_id' => 'required|exists:users,id',
        ]);

        Meetings::create($request->all());


        return redirect()->route('meetings.index')->with('success', 'Meeting created.');
    }
public function show(Meetings $meeting)
{
    $meeting->load('host', 'contact');
    return view('meetings.show', compact('meeting'));
}

public function edit(Meetings $meeting)
{
    $users = User::all();
    $contacts = Contact::all();
    return view('meetings.edit', compact('meeting', 'users', 'contacts'));
}


public function update(Request $request, Meetings $meeting)
{
    $request->validate([
        'title' => 'required',
        'venue' => 'required',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
        'host_id' => 'required|exists:users,id',
    ]);

    $meeting->update($request->all());

    return redirect()->route('meetings.index')->with('success', 'Meeting updated.');
}

public function destroy(Meetings $meeting)
{
    $meeting->delete();
    return redirect()->route('meetings.index')->with('success', 'Meeting deleted.');
}

}

