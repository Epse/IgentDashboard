<?php

namespace App\Policies;

use App\Feedback;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any feedback.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view feedback');
    }

    /**
     * Determine whether the user can view the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function view(User $user, Feedback $feedback)
    {
        return $user->can('view feedback');
    }

    /**
     * Determine whether the user can create feedback.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function update(User $user, Feedback $feedback)
    {
        return $user->can('manage feedback');
    }

    /**
     * Determine whether the user can delete the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function delete(User $user, Feedback $feedback)
    {
        return $user->can('manage feedback');
    }

    /**
     * Determine whether the user can restore the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function restore(User $user, Feedback $feedback)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the feedback.
     *
     * @param  \App\User  $user
     * @param  \App\Feedback  $feedback
     * @return mixed
     */
    public function forceDelete(User $user, Feedback $feedback)
    {
        //
    }
}
