<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The badge instance.
     *
     * @var \Xetaravel\Models\Model
     */
    public $model;

    /**
     * Create a new notification instance.
     *
     * @param \Xetaravel\Models\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
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
        $message = 'Unknown mention.';

        if ($this->model instanceof Comment) {
            $message = '<strong>@%s</strong> has mentionned your name in his comment !';
            $link = route('blog.comment.show', ['id' => $this->model->getKey()]);
        }

        if ($this->model instanceof Article) {
            $message = '<strong>@%s</strong> has mentionned your name in his article !';
            $link = route('blog.article.show', ['slug' => $this->model->slug, 'id' => $this->model->getKey()]);
        }
        $username = $this->model->user->username;

        $message = sprintf($message, $this->model->user->username);

        return [
            'message' => $message,
            'link' => $link,
            'type' => 'mention'
        ];
    }
}
