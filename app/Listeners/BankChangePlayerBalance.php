<?php

namespace App\Listeners;

use App\Events\BankTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\BankMovementType;

class BankChangePlayerBalance
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BankTransaction $event): void
    {
        if ($event->bankTransaction->type === BankMovementType::Withdraw) {            
            // Change player balance
            $event->bankTransaction->player->balance += $event->bankTransaction->amount;
        } else {
            // Change player balance
            $event->bankTransaction->player->balance -= $event->bankTransaction->amount;
        }

        $event->bankTransaction->player->save();
    }
}
