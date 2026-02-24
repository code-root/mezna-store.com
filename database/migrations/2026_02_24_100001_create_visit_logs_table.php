<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('visitable_type'); // App\Models\Category or App\Models\Product
            $table->unsignedBigInteger('visitable_id');
            $table->string('ip_address', 45)->nullable();
            $table->string('city')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('country_name')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamps();
        });

        Schema::table('visit_logs', function (Blueprint $table) {
            $table->index(['visitable_type', 'visitable_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
    }
};
