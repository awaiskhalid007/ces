<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksheetAdditionalItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_items', function (Blueprint $table) {
            $table->id();
            $table->integer('stage_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('plan_id')->nullable();
            $table->integer('measurement_id')->nullable();
            $table->string('part_no')->nullable();
            $table->string('description');
            $table->string('unit');
            $table->string('unit_cost');
            $table->string('markup');
            $table->string('unit_price');
            $table->string('total');
            $table->string('formula')->nullable();
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
        Schema::dropIfExists('additional_items');
    }
}
