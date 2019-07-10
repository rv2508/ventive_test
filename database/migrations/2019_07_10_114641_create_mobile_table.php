<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->string('brand');
            $table->string('model');
            $table->string('color');
            $table->string('description');
            $table->string('os_type');
            $table->string('image');
            $table->tinyInteger('is_delete')->default('0');
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
        Schema::dropIfExists('mobile');
    }
}
