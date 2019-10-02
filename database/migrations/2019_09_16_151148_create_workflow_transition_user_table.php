<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowTransitionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_transition_user', function (Blueprint $table) {
            $table->unsignedBigInteger('workflow_transition_id');
            $table->unsignedBigInteger('user_id')->index();

            $table->foreign('workflow_transition_id')
                ->references('id')->on('workflow_transitions')
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
        Schema::dropIfExists('workflow_transition_user');
    }
}
