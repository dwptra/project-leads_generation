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
        Schema::create('leads_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leads_id');
            $table->enum('status', ['MQL', 'SQL', 'PQL', 'SrQL']);
            $table->date('history_date')->nullable();
            $table->char('keterangan');
            $table->timestamps();

            $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads_histories');
    }
};
