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
            'monday' => 'required|boolean',
            'tuesday' => 'required|boolean',
            'wednesday' => 'required|boolean',
            'thursday' => 'required|boolean',
            'friday' => 'required|boolean',
            'saturday' => 'required|boolean',
            'sunday' => 'required|boolean',
        ]);

        $habit = $request->user()->habits()->create([
            'name' => $request->name,
            'time_of_day' => $request->time_of_day,
            'monday' => $request->monday,
            'tuesday' => $request->tuesday,
            'wednesday' => $request->wednesday,
            'thursday' => $request->thursday,
            'friday' => $request->friday,
            'saturday' => $request->saturday,
            'sunday' => $request->sunday,
        ]);
    

        return response()->json($habit, 201);
    }
    
    public function update(Request $request, $id)
    {
        $habit = Habit::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'time_of_day' => 'sometimes|in:morning,evening',
            'monday' => 'sometimes|boolean',
            'tuesday' => 'sometimes|boolean',
            'wednesday' => 'sometimes|boolean',
            'thursday' => 'sometimes|boolean',
            'friday' => 'sometimes|boolean',
            'saturday' => 'sometimes|boolean',
            'sunday' => 'sometimes|boolean',
        ]);

        $habit->name = $validatedData['name'] ?? $habit->name;
        $habit->time_of_day = $validatedData['time_of_day'] ?? $habit->time_of_day;
        $habit->monday = $validatedData['monday'] ?? $habit->monday;
        $habit->tuesday = $validatedData['tuesday'] ?? $habit->tuesday;
        $habit->wednesday = $validatedData['wednesday'] ?? $habit->wednesday;
        $habit->thursday = $validatedData['thursday'] ?? $habit->thursday;
        $habit->friday = $validatedData['friday'] ?? $habit->friday;
        $habit->saturday = $validatedData['saturday'] ?? $habit->saturday;
        $habit->sunday = $validatedData['sunday'] ?? $habit->sunday;

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
