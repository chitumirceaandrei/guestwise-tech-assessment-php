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
        Schema::table('interactions', function (Blueprint $table) {
            $table->index('occurred_at', 'occurred_at_index');
            $table->index(['brand_id', 'campaign_id'], 'brand_campaign_index');
            $table->index(['campaign_id', 'occured_at'], 'campaign_occured_at_index');
        });
    }
};
