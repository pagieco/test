<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_events', function (Blueprint $table) {
            $table->bigIncrements('local_id');
            $table->unsignedBigInteger('external_id')->unique()->index()->nullable();
            $table->unsignedBigInteger('profile_id')->index();
            $table->unsignedBigInteger('project_id');
            $table->string('event_type');
            $table->json('data')->nullable();
            $table->timestamps();

            $table->foreign('profile_id')
                ->references('local_id')->on('profiles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_events');
    }
}
