@php

use Illuminate\Support\Facades\Auth;

locale_set_default('es_AR');
$date = date_create($mov['created_at']);
$date->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));

$income = $mov['to_player_id'] === $game->userPlayer->id;

@endphp

<li>
    <div class='flex justify-between items-center'>
        <div class='font-geo text-4xl'>
            $ {{ $mov['amount'] }}
        </div>
        <div class='flex justify-end items-center'>
            <div class='text-center mr-2 opacity-70'>
                @if ($income)
                    {{ $mov['from_player']['user']['name'] }}
                @else
                    {{ $mov['to_player']['user']['name'] }}
                @endif
            </div>
            <div
                class='@if ($income) border-green-400 text-green-400 @else border-red-400 text-red-400 @endif p-2 border-2 flex justify-center items-center rounded-lg'>
                @if ($income)
                    {{-- Withdraw --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M20.03 3.97a.75.75 0 0 1 0 1.06L6.31 18.75h9.44a.75.75 0 0 1 0 1.5H4.5a.75.75 0 0 1-.75-.75V8.25a.75.75 0 0 1 1.5 0v9.44L18.97 3.97a.75.75 0 0 1 1.06 0Z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    {{-- Payment --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M8.25 3.75H19.5a.75.75 0 0 1 .75.75v11.25a.75.75 0 0 1-1.5 0V6.31L5.03 20.03a.75.75 0 0 1-1.06-1.06L17.69 5.25H8.25a.75.75 0 0 1 0-1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </div>
    </div>
    <div class='text-center opacity-70 grid grid-cols-2'>
        <div class='flex justify-center items-center'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            {{ $date->format('d/m/y') }}
        </div>
        <div class='flex justify-center items-center'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            {{ $date->format('H:i') }}
        </div>
    </div>
</li>
