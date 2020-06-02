<?php

namespace App\Console\Commands;

use App\voucher;
use Illuminate\Console\Command;

class checkExpiredVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voucher:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check expired voucher today';

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
    public function handle()
    {
        voucher::checkExpiredVoucher();
    }
}
