<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TemplateStagesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id');
            $table->integer('plan_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('project_template_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('multiplier')->nullable();
            $table->integer('all_multiplier')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('takeoff_template_id')->nullable();;
            $table->integer('copy_stage_id')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('template_stages');
    }
}
