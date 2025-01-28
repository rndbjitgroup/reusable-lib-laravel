<?php

namespace App\Interfaces\PermissionsAndRoles;

use App\Models\PermissionsAndRoles\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function getAll(mixed $request): Collection;
    public function get(object $category): ?Role;
    public function store(mixed $request): Role;
    public function update(mixed $request, object $category): ?Role;
    public function destroy(object $category): bool;
}
