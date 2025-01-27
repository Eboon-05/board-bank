<?php

namespace App;

enum BankMovementType: int
{
    case Withdraw = 0;
    case Payment = 1;
}
