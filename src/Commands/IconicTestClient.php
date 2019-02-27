<?php

namespace SYG\Iconic\Commands;

use SYG\Iconic\ApiClient;
use Illuminate\Console\Command;

class IconicTestClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iconic:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iconic Test Client';

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
    public function handle(ApiClient $iconicClient)
    {
        echo $iconicClient->getData('GetOrder', ['OrderId' => 8403541]);
/*        $payload = 
            '<?xml version="1.0" encoding="UTF-8" ?>
            <Request>
              <Webhook>ab5b452f-56f2-48a6-b8bd-c796963c6b21</Webhook>
            </Request>';*/
/*        echo $iconicClient->postData('DeleteWebhook', $payload);*/
    }
}
