<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // return Event::all();
        {
            $events = $request->user()->events()->orderBy('start_time', 'desc')->get();
            return response()->json($events);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time' => 'required|date_format:Y-m-d H:i'
        ]);
    
        $event = $request->user()->events()->create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);
    
        return response()->json($event, 201);
    }
    
    public function show($id)
    {
        return Event::findOrFail($id);
    }
    
    public function update(Request $request, $id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time' => 'required|date_format:Y-m-d H:i'
        ]);
    
        $event->title = $validatedData['title'] ?? $event->title;
        $event->description = $validatedData['description'] ?? $event->description;
        $event->start_time = $validatedData['start_time'] ?? $event->start_time;
        $event->end_time = $validatedData['end_time'] ?? $event->end_time;

        $event->save();

        return response()->json(['message' => 'Event updated successfully', 'event' => $event]);
    }
    
    public function destroy($id)
    {
        $event = Event::where('id',$id)->where('user_id', auth()->id())->firstOrFail();
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
    
}
