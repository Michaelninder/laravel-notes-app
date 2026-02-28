<?php

namespace App\Policies;

use App\Models\NoteBook;
use App\Models\User;

class NoteBookPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, NoteBook $noteBook): bool
    {
        return $user->id === $noteBook->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, NoteBook $noteBook): bool
    {
        return $user->id === $noteBook->user_id;
    }

    public function delete(User $user, NoteBook $noteBook): bool
    {
        return $user->id === $noteBook->user_id;
    }

    public function restore(User $user, NoteBook $noteBook): bool
    {
        return $user->id === $noteBook->user_id;
    }

    public function forceDelete(User $user, NoteBook $noteBook): bool
    {
        return $user->id === $noteBook->user_id;
    }
}