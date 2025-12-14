<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('complaints', function (Blueprint $table) {
        // Adds a status column with a default value of 'Pending'
        $table->string('status')->default('Pending')->after('description');
    });
}

    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('complaints', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
