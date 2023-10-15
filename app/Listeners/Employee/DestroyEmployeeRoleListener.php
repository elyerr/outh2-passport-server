<?php

namespace App\Listeners\Employee;

use App\Events\Employee\DestroyEmployeeRoleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DestroyEmployeeRoleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Employee\DestroyEmployeeRoleEvent  $event
     * @return void
     */
    public function handle(DestroyEmployeeRoleEvent $event)
    {
        //
    }
}