<?php

namespace App\Livewire;

use App\Models\Announcement;
use DB;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Symfony\Contracts\Service\Attribute\Required;

class AnnouncementBlock extends Component
{
    public Announcement $announcement;

    public $hidden = false;

    public function mount(?int $announcementId): void
    {
        if ($announcementId != null) {
            $this->announcement = Announcement::find($announcementId);
        }
    }

    public function markAsRead()
    {
        DB::table('dismissed_announcements')->insert([
            'announcement_id' => $this->announcement->id,
            'user_id' => auth()->id(),
        ]);

        $this->hidden = true;
    }

    public function render()
    {
        return view('livewire.announcement-block');
    }
}
