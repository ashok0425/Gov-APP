<?php

namespace App\Jobs;

use App\Services\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $message;
    public $phone;

    public function __construct($message,$phone)
    {
        $this->message=$message;
        $this->phone=$phone;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $messageObj=new SendMessage();
        $messageObj->send($this->message,$this->phone);
    }
}
