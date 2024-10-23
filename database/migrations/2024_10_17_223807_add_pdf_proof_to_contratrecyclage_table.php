<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contratrecyclage', function (Blueprint $table) {
            $table->string('pdf_proof'); // To store the PDF path
        });
    }

    public function down()
    {
        Schema::table('contratrecyclage', function (Blueprint $table) {
            $table->dropColumn('pdf_proof');
        });
    }

};
