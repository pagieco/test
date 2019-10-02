<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_transitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workflow_id');
            $table->unsignedBigInteger('project_id')->index();
            $table->unsignedBigInteger('from_id');
            $table->unsignedBigInteger('to_id');
            $table->timestamps();

            $table->foreign('workflow_id')
                ->references('id')->on('workflows')
                ->onDelete('cascade');

            $table->foreign('from_id')
                ->references('id')->on('workflow_steps')
                ->onDelete('cascade');

            $table->foreign('to_id')
                ->references('id')->on('workflow_steps')
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
        Schema::dropIfExists('workflow_transitions');
    }
}
