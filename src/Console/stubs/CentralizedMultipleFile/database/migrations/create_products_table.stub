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
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('product_category_id')->constrained();
            $table->string('title');
            //$table->string('slug')->unique();
            $table->string('slug');
            $table->string('identifier_url')->nullable();
            $table->text('description')->nullable();
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL'])->default('M')->nullable();
            $table->string('color', 25)->nullable();
            $table->double('old_price', 8, 2)->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->string('coupon')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->ipAddress('visitor')->nullable();
            $table->macAddress('device')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['slug', 'deleted_at']);
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
