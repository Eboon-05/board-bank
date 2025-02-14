<?php

use function Livewire\Volt\{state};

use App\BankMovementType;

state(['type']);

?>

<div>
    <h1 class='text-xl font-semibold mb-4'>
        @if ($type === BankMovementType::Withdraw)
            Withdraw from bank
        @else
            Pay to bank
        @endif
    </h1>

    <form>
        <label for='initial_balance'>Amount</label>

        <input type='number' wire:model='form.initial_balance'
            class='mt-2 bg-gray-200 rounded-lg w-full border-0 outline-none focus:ring-2 focus:ring-gray-300' />
        @error('form.initial_balance')
            <p class='text-red-600 text-sm'>
                {{ $message }}
            </p>
        @enderror

        <button type='submit' class='mt-4 bg-primary text-white w-full'>
            @if ($type === BankMovementType::Withdraw)
                Withdraw
            @else
                Pay
            @endif
        </button>
    </form>
</div>
