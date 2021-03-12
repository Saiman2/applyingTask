<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_request', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('status_id');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->text('comment')->nullable();
            $table->text('probable_problem');
            $table->text('client_problem_info')->nullable();
            $table->string('time_to_complete');
            $table->text('employees_required_info');
            $table->text('employees_comment')->nullable();
            $table->text('user_comment')->nullable();
            $table->text('changed_parts')->nullable();
            $table->integer('parts_price')->nullable();
            $table->integer('labor_price')->nullable();
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
        Schema::dropIfExists('repair_request');
    }
}
