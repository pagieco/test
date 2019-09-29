<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('local_id');
            $table->unsignedBigInteger('external_id')->unique()->index()->nullable();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('asset_folder_id')->nullable();
            $table->string('hash');
            $table->string('filename');
            $table->string('original_filename');
            $table->text('caption')->nullable();
            $table->text('description')->nullable();
            $table->string('extension');
            $table->string('mimetype');
            $table->integer('filesize');
            $table->json('extra_attributes')->nullable();
            $table->string('path');
            $table->string('thumb_path')->nullable();
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');

            $table->foreign('asset_folder_id')
                ->references('local_id')->on('asset_folders')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
