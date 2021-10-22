<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Make admins authorized to access any review
     *
     * @param User $user
     * @return bool|void
     */
    public function before(User $user){
        if($user->role == 'admin') return true;
    }

    /**
     * Check if the user owns this review
     *
     * @param User $user
     * @param Review $review
     * @return bool
     */
    public function access(User $user , Review $review): bool
    {
        return $review->user_id === $user->id;
    }
}
