<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('centrederecyclage', function (Blueprint $table) {
            $table->unsignedBigInteger('id_utilisateur')->after('id'); // Adjust position if necessary
            $table->foreign('id_utilisateur')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('centrederecyclage', function (Blueprint $table) {
            //
        });
    }
};
