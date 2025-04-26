<?php
// app/Console/Commands/PageViewStats.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class PageViewStats extends Command
{
    protected $signature = 'stats:routes {--top=20 : show top N routes}';
    protected $description = 'Print page-view counters per route (Redis hash pv:routes)';

    public function handle()
    {
        $raw = Redis::hgetall('pv:routes');
        arsort($raw);

        $top = array_slice($raw, 0, $this->option('top'), true);

        $this->table(
            ['Route', 'Hits'],
            collect($top)->map(fn($v,$k)=>[$k,$v])
        );
    }
}