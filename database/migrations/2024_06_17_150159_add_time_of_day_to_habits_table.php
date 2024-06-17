<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeOfDayToHabitsTable extends Migration
{
    public function up()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->string('time_of_day')->after('name'); // 'morning' atau 'evening'
        });
    }

    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn('time_of_day');
        });
    }
}
