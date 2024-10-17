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
            $table->unsignedBigInteger('type_dechet_id')->nullable();

            $table->foreign('type_dechet_id')->references('id')->on('typedechets')->onDelete('cascade');
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
            $table->dropForeign(['type_dechet_id']);
            $table->dropColumn('type_dechet_id');
        });
    }
};
