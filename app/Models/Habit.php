<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $table = 'habits';

    protected $fillable = [
        'user_id',
        'name',
        'time_of_day',
        'description',
        'completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
