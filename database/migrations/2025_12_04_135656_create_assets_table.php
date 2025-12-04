<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // tree, bench, etc.
            $table->string('label');          // Boom, Bankje, etc.
            $table->string('image_url');      // /assets/tree.png
            $table->integer('width');         // grid width
            $table->integer('height');        // grid height
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }

};
