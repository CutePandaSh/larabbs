<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CaculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:caculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算活跃用户';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(\App\Models\User $user)
    {
        $this->info('开始计算');

        $user->caculateAndCacheActiveUsers();

        $this->info('计算完成');
    }
}
