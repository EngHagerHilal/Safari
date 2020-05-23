<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer("company_id")->unsigned();

            $table->string('trip_from');
            $table->enum('status',['active','disabled','completed'])->default('active');
            $table->enum('category',['air flights','land trips','sea trips']);
            $table->string('trip_to');
            $table->string('phone');
            $table->string('price');
            $table->date('start_at');
            $table->date('end_at');
            $table->foreign("company_id")->references("id")->on("companies")->onDelete("cascade")->onUpdate("cascade");

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
        Schema::dropIfExists('trips');
    }
}
