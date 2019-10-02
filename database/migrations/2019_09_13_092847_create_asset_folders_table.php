<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_folders', function (Blueprint $table) {
            $table->bigIncrements('local_id');
            $table->unsignedBigInteger('external_id')->unique()->index()->nullable();
            $table->unsignedBigInteger('project_id')->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('shared')->dropIfExists('asset_folders');
    }
}
