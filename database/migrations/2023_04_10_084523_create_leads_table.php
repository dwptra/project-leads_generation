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
            $table->char('brand');
            $table->char('name');
            $table->char('phone');
            $table->char('email');
            $table->char('instagram');
            $table->char('tiktok');
            $table->char('other');
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
