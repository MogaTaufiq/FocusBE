<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromHabitsTable extends Migration
{
    public function up()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['time_of_day', 'description', 'completed']);
        });
    }

    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->string('time_of_day'); // 'morning' atau 'evening'
            $table->text('description')->nullable();
            $table->boolean('completed')->default(false);
        });
    }
}

