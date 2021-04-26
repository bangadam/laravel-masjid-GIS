<?php

namespace App\Policies;

use App\User;
use App\Models\Ruvid;
use Illuminate\Auth\Access\HandlesAuthorization;

class RuvidPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ruvid.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Ruvid  $ruvid
     * @return mixed
     */
    public function view(User $user, Ruvid $ruvid)
    {
        // Update $user authorization to view $ruvid here.
        return true;
    }

    /**
     * Determine whether the user can create ruvid.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Ruvid  $ruvid
     * @return mixed
     */
    public function create(User $user, Ruvid $ruvid)
    {
        // Update $user authorization to create $ruvid here.
        return true;
    }

    /**
     * Determine whether the user can update the ruvid.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Ruvid  $ruvid
     * @return mixed
     */
    public function update(User $user, Ruvid $ruvid)
    {
        // Update $user authorization to update $ruvid here.
        return true;
    }

    /**
     * Determine whether the user can delete the ruvid.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Ruvid  $ruvid
     * @return mixed
     */
    public function delete(User $user, Ruvid $ruvid)
    {
        // Update $user authorization to delete $ruvid here.
        return true;
    }
}
