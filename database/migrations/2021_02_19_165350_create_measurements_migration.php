<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('stage_id')->nullable();
            $table->integer('plan_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('takeoff_id')->nullable();
            $table->string('part_no');
            $table->string('description');
            $table->string('unit');
            $table->string('unit_cost');
            $table->string('markup');
            $table->string('unit_price');
            $table->longText('symbol')->nullable();
            $table->string('fill')->nullable();
            $table->string('stroke')->nullable();
            $table->string('line_style')->nullable();
            $table->string('line_width')->nullable();
            $table->string('size');
            $table->integer('total')->default(0);
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
        Schema::dropIfExists('measurements');
    }
}
