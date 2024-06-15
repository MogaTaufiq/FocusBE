<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habit;

class HabitController extends Controller
{
    public function index(Request $request)
    {
        $habits = $request->user()->habits()->orderBy('created_at', 'desc')->get();
        return response()->json($habits);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'time_of_day' => 'required|in:morning,evening',
            'description' => 'nullable|string'
        ]);
    
        $habit = $request->user()->habits()->create([
            'name' => $request->name,
            'time_of_day' => $request->time_of_day,
            'description' => $request->description
        ]);
    
        return response()->json($habit, 201);
    }
    
    public function update(Request $request, Habit $habit)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'time_of_day' => 'sometimes|in:morning,evening',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean'
        ]);
    
        $habit->update($request->only(['name', 'time_of_day', 'description', 'completed']));
    
        return response()->json($habit);
    }
    
    public function destroy(Habit $habit)
    {
        $habit->delete();
        return response()->json(['message' => 'Habit deleted']);
    }
}
