<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateInteractionsStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:populate-interactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement("
            INSERT INTO interactions_statistics (campaign_id, brand_id, occurred_at, interactions_count)
            SELECT i.campaign_id, i.brand_id, DATE(i.occurred_at) as occurred_at, COUNT(i.id) as interactions_count
            FROM interactions i
            GROUP BY i.campaign_id, i.brand_id, DATE(i.occurred_at)
            ON DUPLICATE KEY UPDATE interactions_count = VALUES(interactions_count);
        ");
        
        $this->info('Interactions statistics have been populated.');
    }
}
