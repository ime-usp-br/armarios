<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\EmprestimoCriado;
use App\Listeners\EnviarEmailsEmprestimo;
use App\Events\ArmarioLiberado;
use App\Listeners\EnviarEmailsArmarioLiberado;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EmprestimoCriado::class => [
            EnviarEmailsEmprestimo::class,
        ],
        ArmarioLiberado::class => [
            EnviarEmailsArmarioLiberado::class,
            ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
