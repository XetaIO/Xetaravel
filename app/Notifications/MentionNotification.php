<?php

declare(strict_types=1);

namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\Model;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The model instance.
     *
     * @var Model
     */
    public Model $model;

    /**
     * Create a new notification instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Parse the instance of the model and build the array.
     *
     * @param array $data
     *
     * @return array
     */
    protected function parseInstance(array $data = []): array
    {
        $model = $this->model;

        switch (true) {
            case $model instanceof DiscussPost:
                $data['message'] = '<strong>@%s</strong> has mentioned your name in his post !';
                $data['link'] = $model->post_url;

                break;

            case $model instanceof BlogComment:
                $data['message'] = '<strong>@%s</strong> has mentioned your name in his comment !';
                $data['link'] = $model->comment_url;

                break;

            case $model instanceof BlogArticle:
                $data['message'] = '<strong>@%s</strong> has mentioned your name in his article !';
                $data['link'] = $model->article_url;

                break;
        }
        $data['message'] = sprintf($data['message'], $model->user->username);

        return $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via(mixed $notifiable): array
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
    public function toDatabase(mixed $notifiable): array
    {
        return $this->parseInstance(['type' => 'mention']);
    }
}
