<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRectifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rectifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_etudiant')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('id_etat')->constrained('etats');
            $table->foreignId('id_module')->constrained('modules')->onDelete('cascade');
            $table->foreignId('id_element')->constrained('elements')->onDelete('cascade');
            $table->mediumText('commentaire')->nullable();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rectifiers');
    }
}
