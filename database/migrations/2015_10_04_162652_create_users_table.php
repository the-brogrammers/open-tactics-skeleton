<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('access_token', 100)->nullable();
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }

    public function down() {
        Schema::drop('users');
    }
}
