<?php

namespace App\Interfaces\Blogs;

use App\Models\Blogs\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(mixed $request): Collection;
    public function get(object $category): ?Category;
    public function store(mixed $request): Category;
    public function update(mixed $request, object $category): ?Category;
    public function destroy(object $category): bool;
}
