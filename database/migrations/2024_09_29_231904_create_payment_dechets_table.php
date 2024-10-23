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
        Schema::create('payment_dechets', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 8, 2);
            $table->float('quantité');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('annonce_dechet_id')->constrained('annonce_dechets')->onDelete('cascade');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->date('payment_date');
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
        Schema::dropIfExists('payment_dechets');
    }
};
