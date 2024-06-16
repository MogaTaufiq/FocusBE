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
    
    public function update(Request $request, $id)
    {
        $habit = Habit::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'time_of_day' => 'sometimes|in:morning,evening',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        $habit->name = $validatedData['name'] ?? $habit->name;
        $habit->time_of_day = $validatedData['time_of_day'] ?? $habit->time_of_day;
        $habit->description = $validatedData['description'] ?? $habit->description;
        $habit->completed = $validatedData['completed'] ?? $habit->completed;

        $habit->save();

        return response()->json(['message' => 'Habit updated successfully', 'habit' => $habit]);
    }

    
    public function destroy($id)
    {
        $habit = Habit::where('id',$id)->where('user_id', auth()->id())->firstOrFail();
        $habit->delete();
        return response()->json(['message' => 'Habit deleted']);
    }
}
