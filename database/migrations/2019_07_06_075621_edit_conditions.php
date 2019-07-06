<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditConditions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('conditions');

        Schema::create('conditions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('template_id')->unsigned();
            $table->boolean('is_active');
            $table->string('defintion');
            $table->timestamps();

            /**
             * Foreign key on templates->id
             */
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conditions', function (Blueprint $table) {
            //
        });
    }
}
