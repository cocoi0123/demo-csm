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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_type_id')->nullable()->unsigned()->index();
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');

            $table->string('code', 255)->nullable();
            $table->string('name', 255);
            $table->string('image', 255)->nullable();
            $table->double('price', 10, 2)->default(0.00);
            $table->double('cost', 10, 2)->default(0.00);

            $table->string('detail', 255);
            $table->string('file', 255)->nullable();

            $table->boolean('status')->default(1);
            $table->string('create_by', 100)->nullable();
            $table->string('update_by', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
