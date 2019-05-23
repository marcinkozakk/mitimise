<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Default notification saving in database
 *
 * Class DefaultNotification
 * @package App\Notifications
 */
class DefaultNotification extends Notification
{
    use Queueable;

    /**
     * Notification's data
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'text' => $this->data['text'],
            'doer' => $this->data['doer'],
            'target' => $this->data['target'],
            'icon' => $this->data['icon'],
            'redirectTo' => $this->data['redirectTo']
        ];
    }
}
