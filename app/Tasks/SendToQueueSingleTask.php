<?php declare(strict_types=1);

namespace App\Tasks;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use App\Jobs\ProcessAggregatedViews;
use Illuminate\Support\Facades\Redis;

class SendToQueueSingleTask
{
    public function execute(string $courierId): void
    {
        $today = Carbon::now()->toDateString();
        $key = "views:{$courierId}:detail:$today";

        if (!Redis::exists($key)) {
            Redis::set($key, 0);
        }

        Redis::incr($key);
        $count = Redis::get($key);
        logger("Set Redis Key: $key, Count: $count"); // Debug log

        if (!Cache::has('process_views_job')) {
            ProcessAggregatedViews::dispatch()->delay(now()->addSeconds(2));
            Cache::put('process_views_job', true, now()->addSeconds(2));
        }
    }
}
