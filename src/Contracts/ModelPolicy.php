<?php

namespace Vellum\Contracts;

interface ModelPolicy
{

    /**
     * Determine if the given resource can be viewed by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function view(User $user, Post $post);

    /**
     * Determine if the given resource can be updated by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function update(User $user, Post $post);

    /**
     * Determine if the user can create a new resource.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user, Post $post);

    /**
     * Determine if the given resource can be deleted by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function delete(User $user, Post $post);

}