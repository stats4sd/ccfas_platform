<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Action;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $action
     * @return mixed
     */
    public function view(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $action
     * @return mixed
     */
    public function update(User $user, Action $action)
    {
        $user_teams = $user->teams()->get()->pluck('id')->toArray();
     
        return in_array($action->team_id, $user_teams)? Response::allow()
        : Response::deny('Sorry, you cannot edit this action, if you are not part of the team.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $action
     * @return mixed
     */
    public function delete(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $action
     * @return mixed
     */
    public function restore(User $user, Action $action)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $action
     * @return mixed
     */
    public function forceDelete(User $user, Action $action)
    {
        //
    }
}
