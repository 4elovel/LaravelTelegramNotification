<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Models\Post;
use App\Filament\Resources\PostResource;
use App\Models\User;
use App\Notifications\PostMailNotification;
use App\Notifications\PostTelegramNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $post = Post::create($data); // Assuming the parent method should create a Post model directly

        $users = User::query()->where('notification_allowed', true)->get();
        $link = url('/') . '/posts/' . $post->id;

        try {
            Notification::send($users, new PostTelegramNotification($post, $link));
        } catch (CouldNotSendNotification $exception) {
            // Handle exception (optional logging)
        }

        try {
            Notification::send($users, new PostMailNotification($post, $link));
        } catch (CouldNotSendNotification $exception) {
            // Handle exception (optional logging)
        }

        return $post;
    }
}
