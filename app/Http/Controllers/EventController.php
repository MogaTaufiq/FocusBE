<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }
    
    public function store(Request $request)
    {
        $event = Event::create($request->all());
        return response()->json($event, 201);
    }
    
    public function show($id)
    {
        return Event::findOrFail($id);
    }
    
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json($event, 200);
    }
    
    public function destroy($logger)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(null, 204);
    }
    
}
