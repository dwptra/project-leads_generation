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
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->char('brand')->nullable();
            $table->char('name');
            $table->char('phone')->nullable()->unique();
            $table->char('email')->nullable()->unique();
            $table->char('instagram')->nullable();
            $table->char('tiktok')->nullable();
            $table->char('other')->nullable();
            $table->enum('status', ['MQL','SQL','PQL','SrQL'])->default('MQL');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
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
