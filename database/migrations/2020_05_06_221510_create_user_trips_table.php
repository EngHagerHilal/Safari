<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_trips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("trip_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->string("joinCode");
            $table->string("QR_code");
            $table->foreign("trip_id")->references("id")->on("trips")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");

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
        Schema::dropIfExists('user_trips');
    }
}
