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
    Schema::create('animales', function (Blueprint $table) {
        $table->id();
        $table->string('arete', 20)->unique();
        $table->string('especie', 50);
        $table->string('raza', 100);
        $table->char('sexo', 1);
        $table->date('fecha_nacimiento');
        $table->decimal('peso_actual', 6, 2)->nullable();
        $table->string('foto')->nullable();
        $table->foreignId('padre_id')->nullable()->constrained('animales')->nullOnDelete();
        $table->foreignId('madre_id')->nullable()->constrained('animales')->nullOnDelete();
        $table->boolean('activo')->default(true);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::dropIfExists('animales');
}
};
