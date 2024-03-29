<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Hostel;
use App\Models\Vote;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;

class Votes extends Component
{
    use AuthorizesRequests;

    public Hostel $hostel;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function submit(float $score, ?string $description, string $gRecaptchaResponse): void
    {
        $this->authorize('create', [Vote::class, $this->hostel]);

        if ($score < 0.2) {
            Notification::make()
                ->warning()
                ->title('Vui lòng chọn số sao')
                ->send()
            ;

            return;
        }

        if (
            ! \GoogleReCaptchaV3::setAction('livewire_hostel_votes')
                ->verifyResponse($gRecaptchaResponse, \Request::ip())
                ->isSuccess()
        ) {
            Notification::make()
                ->warning()
                ->title('Captcha không hợp lệ')
                ->body('Vui lòng thử lại.')
                ->send()
            ;

            return;
        }

        $this->hostel->votes()->create([
            'description' => $description,
            'score' => $score,
            'owner_id' => \Auth::id(),
        ]);
        Notification::make()
            ->success()
            ->title('Đánh giá thành công')
            ->send()
        ;
        $this->hostel->load('votes.owner');
    }

    public function render(): View
    {
        return view('livewire.hostel.votes', [
            'votes' => $this->hostel->votes,
            'score' => $this->hostel->votes->avg('score'),
            'count' => $this->hostel->votes->count(),
        ]);
    }
}
