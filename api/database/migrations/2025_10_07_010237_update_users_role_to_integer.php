<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar el tipo de columna role de boolean a integer
            // y actualizar los valores existentes: true -> 1, false -> 0
            $table->integer('role')->default(0)->change();
        });
        
        // Actualizar valores existentes
        \DB::statement('UPDATE users SET role = CASE WHEN role = true THEN 1 ELSE 0 END');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir el cambio a boolean
            $table->boolean('role')->default(false)->change();
        });
        
        // Revertir valores: 1 -> true, 0 -> false  
        \DB::statement('UPDATE users SET role = CASE WHEN role = 1 THEN true ELSE false END');
    }
};
