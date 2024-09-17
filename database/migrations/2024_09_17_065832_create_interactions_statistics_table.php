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

        //Check if the table exists
        if (!Schema::hasTable('interactions_statistics')) {
            Schema::create('interactions_statistics', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('campaign_id');
                $table->unsignedBigInteger('brand_id');
                $table->date('occurred_at');
                $table->integer('interactions_count')->default(0);

                // Add indexes
                $table->unique(['campaign_id', 'brand_id', 'occurred_at']);
                $table->index(['campaign_id']);
                $table->index(['brand_id']);
                $table->index(['occurred_at']);
                $table->index(['interactions_count']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions_statistics');
    }
};
