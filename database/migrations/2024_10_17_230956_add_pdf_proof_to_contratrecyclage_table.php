<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contratrecyclage', function (Blueprint $table) {
            // If there are existing records, ensure a default value for 'pdf_proof'
            $table->string('pdf_proof')->change();
        });
    }
    
    public function down()
    {
        Schema::table('contratrecyclage', function (Blueprint $table) {
            // Revert the changes when rolling back
            $table->string('pdf_proof')->nullable()->change();
        });
    }
    
};
