<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Api\Bot\TeleBotController;

class SendHourlyTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to a user with a telegram ChatId';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new TeleBotController();
        $controller->sendMessage();
        return 0;
    }
}
