@php
use App\BankMovementType;
@endphp

<x-app-layout>
    <header class='p-4'>
        @if (empty($type))
            Send money to another player
        @else
            @livewire('games.forms.bank', ['type' => $type, 'game_id' => $game_id])
        @endif
    </header>
</x-app-layout>
