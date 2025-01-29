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
        Schema::create('book_history', function (Blueprint $table) {
            $table->id();
            $table->integer('BookID');
            $table->integer('BorrowedID');
            $table->datetime('Borrowed_date')->nullable();
            $table->datetime('Returned_date')->nullable();
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
        Schema::dropIfExists('book_history');
    }
};
