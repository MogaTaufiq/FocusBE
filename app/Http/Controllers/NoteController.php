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
    
    public function update(Request $request, $id)
    {
        $note = Note::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'pinned' => 'sometimes|boolean'
        ]);
    
        $note->title = $validatedData['title'] ?? $note->title;
        $note->content = $validatedData['content'] ?? $note->content;
        $note->pinned = $validatedData['pinned'] ?? $note->pinned;

        $note->save();

        return response()->json(['message' => 'Note updated successfully', 'note' => $note]);
    }
    
    public function destroy($id)
    {
        $note = Note::where('id',$id)->where('user_id', auth()->id())->firstOrFail();
        $note->delete();
        return response()->json(['message' => 'Note deleted']);
    }
}
