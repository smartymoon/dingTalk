<?php
namespace Smartymoon\DingTalk\Commands;


use Dcat\Admin\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Smartymoon\DingTalk\Api\DingApi;

class EventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dingding:events {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '钉钉官方事件方法: register, update, delete, failed, list';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        if ($action === 'register') {
            // 注册成功了
            dump(DingApi::agent()->callback->register());
        } elseif ($action === 'update') {
            // todo 不知道与 register 的区别
            dump(DingApi::agent()->callback->update());
        } elseif ($action === 'delete' ) {
            dump(DingApi::agent()->callback->delete());
        } elseif ($action === 'failed') {
            dump(DingApi::agent()->callback->failed());
            // 查询成功了
        } elseif ($action === 'list') {
            dump(DingApi::agent()->callback->list());
        } else {
            $this->info("action ${action} not found");
        }
    }
}