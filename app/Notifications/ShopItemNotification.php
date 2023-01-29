<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\ShopItem;

class ShopItemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The item instance.
     *
     * @var ShopItem
     */
    public ShopItem $item;

    /**
     * Create a new notification instance.
     *
     * @param ShopItem $item
     */
    public function __construct(ShopItem $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'You have bought the Xeticon <strong>%s</strong> !',
            'message_key' => [$this->item->title],
            'icon' => $this->item->item_icon,
            'type' => 'shop_item'
        ];
    }
}
