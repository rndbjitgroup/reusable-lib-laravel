<?php

namespace App\Interfaces\Blogs;

use App\Models\Blogs\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getAll(mixed $request): LengthAwarePaginator;
    public function get(object $post): ?Post;
    public function store(mixed $request): Post;
    public function update(mixed $request, object $post): ?Post;
    public function destroy(object $post): bool;
}
