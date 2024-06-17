<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $user = $request->user();

        // Hitung jumlah agenda hari ini
        $today = Carbon::today();
        $upcomingEventsCount = $user->events()
            ->whereDate('start_time', $today)
            ->count();

        // Hitung jumlah tugas yang belum selesai
        $toDoCount = $user->todos()
            ->where('completed', false)
            ->count();

        // Hitung jumlah habit yang belum selesai hari ini
        $habitsLeftCount = $user->habits()
            ->where('completed', false)
            ->whereDate('created_at', $today)
            ->count();

        return response()->json([
            'upcomingEventsCount' => $upcomingEventsCount,
            'toDoCount' => $toDoCount,
            'habitsLeftCount' => $habitsLeftCount,
        ]);
    }
}
