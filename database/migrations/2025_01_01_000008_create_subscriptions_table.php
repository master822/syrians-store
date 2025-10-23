<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plan_type'); // basic, medium, premium
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable(); // ID from payment gateway
            $table->string('status')->default('pending'); // pending, completed, failed, cancelled
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Add subscription fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('current_plan')->default('free')->after('store_logo');
            $table->timestamp('subscription_start')->nullable()->after('current_plan');
            $table->timestamp('subscription_end')->nullable()->after('subscription_start');
            $table->boolean('is_trial_used')->default(false)->after('subscription_end');
            $table->integer('trial_days')->default(60)->after('is_trial_used'); // 2 months
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['current_plan', 'subscription_start', 'subscription_end', 'is_trial_used', 'trial_days']);
        });
    }
};
