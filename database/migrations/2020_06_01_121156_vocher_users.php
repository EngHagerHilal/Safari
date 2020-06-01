<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VocherUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("voucher_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("trip_id")->unsigned();
            $table->foreign("voucher_id")->references("id")->on("vouchers")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("trip_id")->references("id")->on("trips")->onDelete("cascade")->onUpdate("cascade");

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
        Schema::dropIfExists('voucher_users');
    }
}
