<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\shopify_app;
use App\Models\inboundlink;
use Illuminate\Support\Facades\Http;
class MyScheduledTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:my-scheduled-task';

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
         $response = Http::get('https://localhost/shop_app/api/insertdata');
        // Log::info('cron is working fine');
    // $stores=shopify_app::pluck('storename');
    // $entry=new inboundlink();
    // $entry->outbound_store=$stores;
    // $entry->save();
    }
}
