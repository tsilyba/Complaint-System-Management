<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            // Link complaint to the logged-in user
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('name');
            $table->string('address');
            $table->string('contact_number');
            $table->enum('issue_type', [
                'potholes', 
                'broken facilities', 
                'garbage collection', 
                'streetlights issue', 
                'flooding', 
                'others'
            ]);
            $table->text('description');
            $table->string('image_path')->nullable(); // Stores the file path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaints');
    }
};
