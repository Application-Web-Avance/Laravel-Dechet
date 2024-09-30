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
        Schema::create('contratrecyclage', function (Blueprint $table) {
            $table->id();
            $table->date('date_signature');
            $table->time('duree_contract');
            $table->float('montant');
            $table->enum('typeContract', ['accepté','refusé','en cours']);
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
        Schema::dropIfExists('contratrecyclage');
    }
};
