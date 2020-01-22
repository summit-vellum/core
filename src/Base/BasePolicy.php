<?php

namespace Vellum\Base;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given resource can be viewed by the user.
     *
     * @param  \App\User  $user
     * @param  \Quill\Post\Models\Post  $post
     * @return bool
     */
    public function view(User $user, Model $model)
    {
        return $user->permissions($this->module)->contains('view');
    }

    /**
     * Determine if the given resource can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \Quill\Post\Models\Post  $post
     * @return bool
     */
    public function update(User $user, Model $model)
    {
        return $user->permissions($this->module)->contains('update');
    }

    /**
     * Determine if the user can create a new resource.
     *
     * @param  \App\User  $user
     * @param  \Quill\Post\Models\Post  $post
     * @return bool
     */
    public function create(User $user)
    {
        return $user->permissions($this->module)->contains('create');
    }

    /**
     * Determine if the given resource can be deleted by the user.
     *
     * @param  \App\User                $user
     * @param  \Quill\Post\Models\Post  $post
     * @return bool
     */
    public function delete(User $user, Model $model)
    {

        return $user->permissions($this->module)->contains('delete');
    }

    public function before(User $user)
    {
        if ($user->permissions($this->module)->contains('*')) {
            return true;
        }
    }
}
