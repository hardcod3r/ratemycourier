<?php
namespace App\Jobs;

use App\Models\AggregatedView;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Enums\ViewType;
use Illuminate\Support\Facades\Log;
class ProcessAggregatedViews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function handle()
    {
        $today = now()->toDateString();
        $redis = Redis::connection()->client();
        $redisPrefix = config('database.redis.options.prefix') ?? '';

        $cursor = null;
        $keys = [];
        do {
            $result = $redis->scan($cursor,"{$redisPrefix}views:*:{$today}", 100);
            if ($result !== false) {
                $keys = array_merge($keys, $result);
            }
        } while ($cursor !== 0);

        DB::transaction(function () use ($keys, $redis, $redisPrefix, $today) {
            foreach ($keys as $key) {
                $cleanKey = str_replace($redisPrefix, '', $key);

                if (!preg_match("/([a-f0-9\-]+):(list|detail):$today$/", $cleanKey, $matches)) {
                    logger("Skipping Key: $key (No Match)");
                    continue;
                }

                $courierId = $matches[1];
                $type = ($matches[2] === "list") ? ViewType::List : ViewType::Detail;
                $rkey = "views:$courierId:$matches[2]:$today";
                $count = $redis->get($rkey);

                if ($count === false || !is_numeric($count) || $count <= 0) {
                    logger("Deleting Key (Empty or Invalid Count): $key");
                    $redis->del($rkey);
                    continue;
                }
                if (!DB::table('couriers')->where('id', $courierId)->exists()) {
                    Log::error("Courier ID $courierId does not exist in couriers table.");
                    $redis->del($rkey);
                    return;
                }

                DB::table('aggregated_views')->updateOrInsert(
                    ['courier_id' => $courierId, 'type' => $type, 'view_date' => $today],
                    [
                        'views' => DB::raw("views + $count"),
                        'updated_at' => now(),
                    ]
                );
                $redis->set($rkey, 0);
            }
        });

        Cache::forget('process_views_job');
    }



}
