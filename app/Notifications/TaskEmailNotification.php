<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public  $user, $task, $message;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $task, $message)
    {
        $this->user = $user;
        $this->task = $task;
        $this->message = $message;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->message . ' - ' . $this->task->title . ' created by ' . $this->user->name . ' for you!')
                    ->action('Open Task MIS', url('http://localhost/TaskMis/'))
                    ->line('Thank you for using Task Tracking MIS!');
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
            //
        ];
    }
}
