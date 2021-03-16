<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_plan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('project_id');
            $table->integer('user_id');
            $table->integer('group_id')->nullable();
            $table->longText('plan_image');
            $table->string('salt');
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
        Schema::dropIfExists('project_plan');
    }
}
