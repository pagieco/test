<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workflow_id');
            $table->unsignedBigInteger('project_id')->index();
            $table->string('name');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->foreign('workflow_id')
                ->references('id')->on('workflows')
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
        Schema::dropIfExists('workflow_steps');
    }
}
