<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('permission_id')->nullable()->unsigned()->index();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->string('code', 50)->unique()->charset('utf8');
            $table->string('username', 50)->unique()->charset('utf8');
            $table->string('password', 100)->charset('utf8')->nullable();
            $table->string('name', 255)->charset('utf8');
            $table->string('email', 100)->charset('utf8')->nullable();
            $table->string('tel', 100)->charset('utf8')->nullable();
            $table->date('register_date')->nullable();
            $table->enum('status', ['Yes', 'No', 'Request'])->charset('utf8')->default('No');

            $table->string('create_by', 255)->charset('utf8')->nullable();
            $table->string('update_by', 255)->charset('utf8')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
