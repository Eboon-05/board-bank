@php

locale_set_default('es_AR');
$date = date_create($mov['created_at']);
$date->setTimezone(new DateTimeZone('America/Buenos_Aires'));

@endphp

<li>
    <div class='flex justify-between items-center'>
        <div class='font-geo text-4xl'>
            $ {{ $mov['amount'] }}
        </div>
        <div class='flex justify-end items-center'>
            <div class='text-center mr-2 opacity-70'>
                Bank @if ($mov['type'] === 0) withdraw @else payment @endif
            </div>
            <div
                class='@if ($mov['type'] === 0) border-green-400 text-green-400 @else border-red-400 text-red-400 @endif p-2 border-2 flex justify-center items-center rounded-lg'>
                @if ($mov['type'] === 0)
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
        <p>
            {{ $date->format('d/m/y') }}
        </p>
        <p>
            {{ $date->format('H:i') }}
        </p>
    </div>
</li>
