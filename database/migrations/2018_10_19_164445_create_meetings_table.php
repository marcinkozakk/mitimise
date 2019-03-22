<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            $table->text('description');
            $table->boolean('is_private');
            $table->boolean('is_canceled');
            $table->unsignedInteger('organizer_id');
            $table->unsignedInteger('place_id')->nullable();

            $table->foreign('organizer_id', 'user_organises_meeting')->references('id')->on('users');
            $table->foreign('place_id', 'meeting_takes_place_in_place')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
