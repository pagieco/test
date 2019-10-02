<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_fields', function (Blueprint $table) {
            $table->bigIncrements('local_id');
            $table->unsignedBigInteger('external_id')->unique()->index()->nullable();
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('project_id')->index();
            $table->string('display_name');
            $table->string('slug');
            $table->json('validations')->nullable();
            $table->string('type');
            $table->timestamps();

            $table->foreign('collection_id')
                ->references('local_id')->on('collections')
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
        Schema::dropIfExists('collection_fields');
    }
}
