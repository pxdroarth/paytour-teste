<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('email', 150);
            $table->string('telefone', 30);
            $table->string('cargo_desejado', 120);
            $table->string('escolaridade', 30); // Fundamental, Médio, Técnico, Superior, Pos, Outro
            $table->text('observacoes')->nullable();
            $table->string('arquivo_path'); 
            $table->string('ip', 45)->nullable();
            $table->timestamp('enviado_em');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('candidaturas');
    }
};
