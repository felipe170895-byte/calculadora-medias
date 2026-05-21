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
    Schema::create('notas', function (Blueprint $table) {
        $table->id();

        $table->foreignId('aluno_id')
            ->unique()
            ->constrained('alunos')
            ->onDelete('cascade');

        $table->decimal('nota1', 4, 2);
        $table->decimal('nota2', 4, 2);
        $table->decimal('nota3', 4, 2);
        $table->decimal('nota4', 4, 2);

        $table->decimal('media', 4, 2)->nullable();
        $table->string('conceito')->nullable();
        $table->string('mensagem')->nullable();

        $table->decimal('nota_recuperacao', 4, 2)->nullable();
        $table->string('resultado_recuperacao')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
