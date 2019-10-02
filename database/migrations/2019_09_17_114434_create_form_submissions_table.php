<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->unsignedBigInteger('project_id')->index();
            $table->json('submission_data');
            $table->timestamps();

            $table->foreign('form_id')
                ->references('id')->on('forms')
                ->onDelete('cascade');

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
        Schema::dropIfExists('form_submissions');
    }
}
