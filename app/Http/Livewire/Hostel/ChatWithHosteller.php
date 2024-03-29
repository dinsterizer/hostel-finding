<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Events\ChatRoomCreated;
use App\Models\ChatRoom;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class ChatWithHosteller extends Component
{
    public User $hosteller;

    public function mount(User $hosteller): void
    {
        $this->hosteller = $hosteller;
    }

    public function chatWithHosteller(): void
    {
        if (! \Auth::check()) {
            Notification::make()
                ->warning()
                ->title(__('Login required'))
                ->body(__('Please login to chat with hosteller.'))
                ->send()
            ;

            return;
        }

        $user1Id = \Auth::id() < $this->hosteller->id ? \Auth::id() : $this->hosteller->id;
        $user2Id = \Auth::id() > $this->hosteller->id ? \Auth::id() : $this->hosteller->id;

        $room = ChatRoom::firstOrCreate([
            'user1_id' => $user1Id,
            'user2_id' => $user2Id,
        ]);

        ChatRoomCreated::dispatch($room);
    }

    public function render(): View
    {
        return view('livewire.hostel.chat-with-hosteller');
    }
}
