<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->longText('description');
            $table->longText('body_mail')->nullable();
            $table->string('status');
            $table->string('subject_mail')->nullable();
            $table->string('email_uid')->nullable();
            $table->string('email')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
