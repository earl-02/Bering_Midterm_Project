<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('genre')->nullable();
            $table->integer('release_year')->nullable();
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('platform_id')
                ->references('id')
                ->on('platforms')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['platform_id']);
        });
        Schema::dropIfExists('games');
    }
};
