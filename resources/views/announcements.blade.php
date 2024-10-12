@livewire('announcement-block', ['announcementId' => auth()->user()->findLatestAnnouncement()])
