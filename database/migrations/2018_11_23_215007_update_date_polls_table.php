<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('date_polls', function (Blueprint $table) {
            $table->dropForeign('date_poll_refers_invitation');
            $table->dropColumn('invitation_id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('meeting_id');
            $table->timestamps();

            $table->foreign('meeting_id', 'date_poll_refers_meeting')->references('id')->on('meetings');
            $table->foreign('user_id', 'user_answers_date_poll')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('date_polls', function (Blueprint $table) {
            $table->dropForeign('date_poll_refers_meeting');
            $table->dropForeign('user_answers_date_poll');
            $table->dropColumn('user_id');
            $table->dropColumn('meeting_id');
            $table->dropTimestamps();

            $table->unsignedInteger('invitation_id');

            $table->foreign('invitation_id', 'date_poll_refers_invitation')->references('id')->on('invitations');
        });
    }
}
