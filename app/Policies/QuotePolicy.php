<?php

namespace App\Policies;

use App\User;
use App\Quote;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Quote $quote)
    {
        return $user->ownQuote($quote);
    }

    public function delete(User $user, Quote $quote)
    {
        return $user->ownQuote($quote);
    }
}
