<div>
    @if($announcement != null && !$hidden)
        <x-filament::section icon="heroicon-o-bell" class="mt-6" compact>
            <x-slot name="heading">
                Announcement from: {{$this->announcement->user->full_name}}
            </x-slot>

            <x-slot name="description">
                Date posted: {{$this->announcement->created_at}}
            </x-slot>

            {!! $this->announcement->message !!}

            <x-slot name="headerEnd">
                <x-filament::icon-button icon="heroicon-o-x-mark" wire:click="markAsRead"/>
            </x-slot>
        </x-filament::section>
    @endif
</div>
