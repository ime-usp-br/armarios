<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Emprestimo;
use App\Models\Armario;



class EmprestimoCriado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $emprestimo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Emprestimo $emprestimo)
    {
        $this->emprestimo = $emprestimo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
