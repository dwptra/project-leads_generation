<?php

use App\Models\Owner;

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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('brand');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('instagram');
            $table->string('tiktok');
            $table->string('other');
            $table->enum('status', ['MQL','SQL','PQL','SrQL']);
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
        Schema::dropIfExists('leads');
    }
};
