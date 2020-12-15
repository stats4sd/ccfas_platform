<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Effect;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class EffectPolicy
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
     * @param  \App\Models\Effect  $effect
     * @return mixed
     */
    public function view(User $user, Effect $effect)
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
     * @param  \App\Models\Effect  $effect
     * @return mixed
     */
    public function update(User $user, Effect $effect)
    {
        $user_teams = $user->teams()->get()->pluck('id')->toArray();
        Log::info($user_teams);
     
        return in_array($effect->team_id, $user_teams)? Response::allow()
        : Response::deny('Sorry, you cannot edit this effect, if you are not part of the team.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Effect  $effect
     * @return mixed
     */
    public function delete(User $user, Effect $effect)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Effect  $effect
     * @return mixed
     */
    public function restore(User $user, Effect $effect)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Effect  $effect
     * @return mixed
     */
    public function forceDelete(User $user, Effect $effect)
    {
        //
    }
}
