<?php

namespace App\Interfaces\PermissionsAndRoles;

use App\Models\PermissionsAndRoles\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    public function getAll(mixed $request): Collection;
    public function get(object $category): ?Permission;
    public function store(mixed $request): Permission;
    public function update(mixed $request, object $category): ?Permission;
    public function destroy(object $category): bool;
}
