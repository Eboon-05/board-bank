@php
use App\BankMovementType;
@endphp

<x-app-layout>
    @switch($type)
        @case(BankMovementType::Withdraw->value)
            Bank withdraw
            @break
        @case(BankMovementType::Payment->value)
            Bank payment
            @break
        @default
            Player movement
    @endswitch
</x-app-layout>
