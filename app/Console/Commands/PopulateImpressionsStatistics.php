<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateImpressionsStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:populate-impressions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        DB::statement("
            INSERT INTO impressions_statistics (campaign_id, brand_id, occurred_at, impressions_count)
            SELECT i.campaign_id, i.brand_id, DATE(i.occurred_at) as occurred_at, COUNT(i.id) as impressions_count
            FROM impressions i
            GROUP BY i.campaign_id, i.brand_id, DATE(i.occurred_at)
            ON DUPLICATE KEY UPDATE impressions_count = VALUES(impressions_count);
        ");
        
        $this->info('Impressions statistics have been populated.');
    }
}
