<?php

namespace App\Policies;

use App\Models\Horario;
use App\Models\User;

class HorarioPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isMedico() || $user->isAsistente();
    }

    public function view(User $user, Horario $horario): bool
    {
        if ($user->isAdmin() || $user->isAsistente()) {
            return true;
        }

        return $user->isMedico() && (int) $horario->medico_id === (int) $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function update(User $user, Horario $horario): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function delete(User $user, Horario $horario): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }
}
