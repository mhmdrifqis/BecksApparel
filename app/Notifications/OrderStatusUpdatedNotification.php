<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    public $order;
    public $customMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, $customMessage = null)
    {
        $this->order = $order;
        $this->customMessage = $customMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusLabels = [
            'pending' => 'Menunggu Pembayaran',
            'production' => 'Sedang Diproses/Dijahit',
            'shipped' => 'Sedang Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'returned' => 'Diretur'
        ];
        
        $statusText = $statusLabels[$this->order->order_status] ?? $this->order->order_status;
        $message = $this->customMessage ?? "Status pesanan {$this->order->invoice_number} Anda telah diperbarui menjadi: **{$statusText}**.";
        
        if ($this->order->order_status == 'shipped' && $this->order->tracking_number) {
            $message .= " Nomor Resi: " . $this->order->tracking_number;
        }

        return [
            'order_id' => $this->order->id,
            'invoice_number' => $this->order->invoice_number,
            'title' => 'Update Status Pesanan',
            'message' => $message,
            'url' => route('customer.orders.show', $this->order->id),
            'type' => 'status_update'
        ];
    }
}
