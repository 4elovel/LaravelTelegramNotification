<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostMailNotification extends Notification
{
    use Queueable;
    private Post $post;
    private string $link;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post,string $link)
    {
        $this->post=$post;
        $this->link=$link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(`New post: ` . $this->post->title)
                    ->line('Someone just created new post in your favourite blog.')
                    ->action('Check it right now', $this->link)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
