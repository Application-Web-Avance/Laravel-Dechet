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
        Schema::table('contratrecyclage', function (Blueprint $table) {
            $table->integer('duree_contract')->change(); // Changing it to integer
        });
    }

    public function down()
    {
        Schema::table('contratrecyclage', function (Blueprint $table) {
            $table->time('duree_contract')->change(); // Revert to time if needed
        });
    }

};
