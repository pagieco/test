<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_user', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('user_id')->index();

            $table->foreign('form_id')
                ->references('id')->on('forms')
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
        Schema::dropIfExists('form_user');
    }
}
