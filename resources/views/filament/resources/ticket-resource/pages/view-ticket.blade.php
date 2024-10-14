@php($ticket = $this->record)

<x-filament-panels::page>

    <x-filament::tabs>
        <x-filament::tabs.item active="{{$activeTab == 'reply'}}" icon="heroicon-o-chat-bubble-bottom-center-text"
                               wire:click="setActiveTab('reply')"> Add Reply
        </x-filament::tabs.item>
        <x-filament::tabs.item active="{{$activeTab == 'tasks'}}" icon="heroicon-o-rectangle-stack"
                               wire:click="setActiveTab('tasks')">Tasks
        </x-filament::tabs.item>
    </x-filament::tabs>

    @if($activeTab == "reply")
        <x-filament-panels::form wire:submit="saveReply">
            {{$this->replyForm}}

            <x-filament-panels::form.actions
                :actions="$this->getFormActions()"
            />
        </x-filament-panels::form>
    @endif

    @if($activeTab == "tasks")
        @livewire('tables.tasks', ['relatedType' => \App\Models\Ticket::class, 'relatedId' => $ticket->id])
    @endif

    @if($ticket->replies()->exists())
        @foreach($ticket->replies()->latest()->get() as $reply)
            <x-filament::section compact>
                <div>
                    <b>{{$reply->creator_name}}</b>
                    <small>Customer</small>
                </div>

                <div class="mt-2">
                    {!! $reply->content !!}
                </div>

                <div class="text-right mt-4 text-sm text-gray-500">
                    Posted: {{$reply->created_at->diffForHumans()}}
                </div>
            </x-filament::section>
        @endforeach
    @endif

</x-filament-panels::page>
