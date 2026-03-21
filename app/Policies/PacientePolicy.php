<?php

namespace App\Policies;

use App\Models\Paciente;
use App\Models\User;

class PacientePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isMedico() || $user->isAsistente();
    }

    public function view(User $user, Paciente $paciente): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function update(User $user, Paciente $paciente): bool
    {
        return $user->isAdmin() || $user->isAsistente();
    }

    public function delete(User $user, Paciente $paciente): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
