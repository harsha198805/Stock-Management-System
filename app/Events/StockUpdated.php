<?php
namespace App\Events;

use App\Models\StockItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StockUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public StockItem $stockItem;

    public function __construct(StockItem $stockItem)
    {
        $this->stockItem = $stockItem;
    }

    public function broadcastOn()
    {
        return new Channel('stock-channel');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->stockItem->id,
            'name' => $this->stockItem->name,
            'quantity' => $this->stockItem->quantity,
        ];
    }
}
