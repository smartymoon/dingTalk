<?php
namespace Smartymoon\DingTalk\Commands;


use Dcat\Admin\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class RegisterEventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dingding:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '向钉钉官方注册回调的事件们';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // todo 确认成功还是失败
        $this->info('');
    }
}