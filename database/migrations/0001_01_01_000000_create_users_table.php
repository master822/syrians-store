<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_type', ['user', 'merchant', 'admin'])->default('user');
            $table->string('phone')->nullable();
            $table->string('city');
            
            // حقول إضافية للتجار
            $table->string('store_name')->nullable();
            $table->enum('store_category', ['clothes', 'electronics', 'home', 'grocery'])->nullable(); // أضفنا grocery هنا
            $table->text('store_description')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_city')->nullable();
            
            // حقول الاشتراك
            $table->enum('subscription_plan', ['free', 'basic', 'medium', 'premium'])->default('free');
            $table->integer('product_limit')->default(0);
            $table->timestamp('subscription_ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
