<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');         // Nama menu
            $table->string('url')->nullable();  // URL menu
            $table->string('icon')->nullable(); // Ikon menu (jika ada)
            $table->integer('parent_id')->nullable(); // ID menu induk, untuk sub-menu
            $table->integer('order')->default(0);  // Urutan tampilan
            $table->enum('role', ['admin', 'user', 'editor'])->default('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
