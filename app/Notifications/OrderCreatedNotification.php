<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Menyimpan di database untuk ditampilkan via Web UI
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'invoice_number' => $this->order->invoice_number,
            'amount' => $this->order->total_amount,
            'title' => 'Pesanan Baru Masuk!',
            'message' => 'Pesanan baru ' . $this->order->invoice_number . ' senilai Rp ' . number_format($this->order->total_amount, 0, ',', '.') . ' telah dibuat oleh ' . $this->order->user->name . '.',
            'url' => route('admin.orders.show', $this->order->id),
            'type' => 'new_order'
        ];
    }
}
