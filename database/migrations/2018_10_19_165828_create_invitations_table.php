<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('state', ['undecided', 'going'])->default('undecided');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('meeting_id');

            $table->foreign('user_id', 'user_gets_invitation')->references('id')->on('users');
            $table->foreign('meeting_id', 'invitation_refers_meeting')->references('id')->on('meetings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
