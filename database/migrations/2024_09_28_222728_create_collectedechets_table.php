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
        Schema::create('collectedechets', function (Blueprint $table) {
            $table->id();
            $table->string('nomEvent')->nullable();
            $table->dateTime('date');
            $table->string('lieu');
            $table->integer('nbparticipant');
            $table->integer('Maxnbparticipant');
            $table->string('description');
            $table->string('image')->nullable();
            $table->foreignId('type_de_dechet_id')->constrained('typedechets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('collectedechets');
    }
};
