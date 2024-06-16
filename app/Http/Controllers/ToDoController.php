<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;

class ToDoController extends Controller
{
    public function index(Request $request)
    {
        $todos = $request->user()->todos()->orderBy('created_at', 'desc')->get();
        return response()->json($todos);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'nullable|date'
        ]);
    
        $todo = $request->user()->todos()->create([
            'title' => $request->title,
            'deadline' => $request->deadline
        ]);
    
        return response()->json($todo, 201);
    }
    
    public function update(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'deadline' => 'nullable|date',
            'completed' => 'sometimes|boolean'
        ]);
    
        $todo->title = $validatedData['title'] ?? $todo->title;
        $todo->deadline = $validatedData['deadline'] ?? $todo->deadline;
        $todo->completed = $validatedData['completed'] ?? $todo->completed;

        $todo->save();

        return response()->json(['message' => 'Todo updated successfully', 'todo' => $todo]);
    }
    
    public function destroy($id)
    {
        $todo = Todo::where('id',$id)->where('user_id', auth()->id())->firstOrFail();
        $todo->delete();
        return response()->json(['message' => 'ToDo deleted']);
    }
}
