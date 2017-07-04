<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\Article;
use Xetaravel\Models\Comment;
use Xetaravel\Models\DiscussPost;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The model instance.
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
        return $this->parseInstance(['type' => 'mention']);
    }

    /**
     * Parse the instance of the model and build the array.
     *
     * @param array $data
     *
     * @return array
     */
    protected function parseInstance(array $data = [])
    {
        $model = $this->model;

        switch (true) {
            case $model instanceof DiscussPost:
                $data['message'] = '<strong>@%s</strong> has mentionned your name in his post !';
                $data['link'] = $model->post_url;

                break;

            case $model instanceof Comment:
                $data['message'] = '<strong>@%s</strong> has mentionned your name in his comment !';
                $data['link'] = $model->comment_url;

                break;

            case $model instanceof Article:
                $data['message'] = '<strong>@%s</strong> has mentionned your name in his article !';
                $data['link'] = $model->article_url;

                break;

            default:
                $data['message'] = 'Unknown mention.';
                $data['link'] = route('users.notification.index');

                break;
        }
        $data['message'] = sprintf($data['message'], $model->user->username);

        return $data;
    }
}
