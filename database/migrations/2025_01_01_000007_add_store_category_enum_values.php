<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // لـ SQLite نحتاج نهج مختلف - إنشاء جدول مؤقت
        Schema::table('users', function (Blueprint $table) {
            // لا يمكن تعديل ENUM في SQLite بسهولة، سنستخدم نهج بديل
            // سنتركه كما هو وسنتعامل معه في الكود
        });
    }

    public function down()
    {
        // لا يمكن التراجع بسهولة في SQLite
    }
};
