<?php

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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('parent_id')->default('0');
            $table->integer('department_id');
            $table->integer('performed_by')->default('0');
            $table->string('title');
            $table->text('description');
            $table->string('priority');
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('progress')->default('0');
            $table->text('result')->nullable();
            $table->string('file')->nullable();
            $table->boolean('status')->default('0');
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
        Schema::dropIfExists('tasks');
    }
};
