<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $notes = $request->user()->notes;
        return response()->json($notes);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'pinned' => 'sometimes|boolean'
        ]);
    
        $note = $request->user()->notes()->create([
            'title' => $request->title,
            'content' => $request->content,
            'pinned' => $request->boolean('pinned', false)
        ]);
    
        return response()->json($note, 201);
    }
    
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'pinned' => 'sometimes|boolean'
        ]);
    
        $note->update($request->only(['title', 'content', 'pinned']));
    
        return response()->json($note);
    }
    
    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['message' => 'Note deleted']);
    }
}
