<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_polls', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->enum('availability', ['yes', 'no'])->default('yes')->nullable();
            $table->unsignedInteger('invitation_id');

            $table->foreign('invitation_id', 'date_poll_refers_invitation')->references('id')->on('invitations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_polls');
    }
}
