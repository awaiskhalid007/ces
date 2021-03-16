<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStatusMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectstatus', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->integer('user_id');
            $table->string('color');
            $table->integer('sort');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('projectstatus');
    }
}
