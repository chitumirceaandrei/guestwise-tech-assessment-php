<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateConversionsStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:populate-conversions';

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
            INSERT INTO conversions_statistics (campaign_id, brand_id, occurred_at, conversions_count)
            SELECT i.campaign_id, i.brand_id, DATE(i.occurred_at) as occurred_at, COUNT(i.id) as conversions_count
            FROM conversions i
            GROUP BY i.campaign_id, i.brand_id, DATE(i.occurred_at)
            ON DUPLICATE KEY UPDATE conversions_count = VALUES(conversions_count);
        ");
        
        $this->info('Conversions statistics have been populated.');
    }
}
