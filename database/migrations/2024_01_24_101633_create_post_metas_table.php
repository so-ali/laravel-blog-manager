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
        Schema::create('post_metas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("post_id");
            $table->foreign("post_id")->references("ID")->on("posts");
            $table->longText("key");
            $table->longText("value");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_metas');
    }
};
