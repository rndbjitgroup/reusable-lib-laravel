<?php

namespace App\Interfaces\Blogs;

use App\Models\Blogs\Comment;
use App\Models\Blogs\Post;

interface CommentRepositoryInterface
{
    public function get(object $category): ?Comment;
    public function getById(int $id): ?Comment;
    public function store(mixed $request, object $post): Post;  
    public function storeReply(mixed $request, object $post): Post; 
    public function destroy(object $category): bool;
}
