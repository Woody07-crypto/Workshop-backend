<?php

namespace App\Policies;

use App\Models\ExpedienteClinico;
use App\Models\User;

class ExpedienteClinicoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isMedico() || $user->isAsistente();
    }

    public function view(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function update(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function delete(User $user, ExpedienteClinico $expedienteClinico): bool
    {
        return $user->isAdmin();
    }
}
