<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    private $user;
    public function __construct(){
        $this->user = Auth::user();
    }
    public function viewAny(): bool
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return $this->user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return $this->user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return $this->user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return $this->user->is_admin;
    }
}
