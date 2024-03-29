<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {

            $colors = ['red', 'blue', 'green', 'white', 'yellow', 
            'black', 'pink', 'purple', 'orange', 'turqoise', 'brown', 'grey'];

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->longText('text');
            $table->boolean('archived')->default(false);
            $table->boolean('pinned')->default(false);
            $table->enum('color', $colors)->default('white');
            $table->string('image_name', 256)->nullable();
            $table->boolean('has_image')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
