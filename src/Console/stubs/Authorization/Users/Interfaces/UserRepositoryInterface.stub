<?php

namespace App\Interfaces\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAll(mixed $request): LengthAwarePaginator;
    public function list(mixed $request): Collection;
    public function get(object $user): ?User; 
    public function store(mixed $request): User;
    public function update(mixed $request, object $user): ?User;
    public function destroy(object $user): bool; 
}
