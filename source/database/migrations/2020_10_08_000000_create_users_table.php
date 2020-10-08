<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name', 20)->comment('이름');
            $table->string('nickname', 30)->comment('별명');
            $table->string('password')->comment('비밀번호');
            $table->string("phone", 20)->comment('전화번호');
            $table->string('email', 100)->unique()->comment('이메일');
            $table->enum('gender', ['M', 'F'])->nullable()->comment('성별');

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
        Schema::dropIfExists('users');
    }
}
