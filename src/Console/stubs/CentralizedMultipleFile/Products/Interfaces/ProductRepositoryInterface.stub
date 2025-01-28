<?php

namespace App\Interfaces\Products;

use App\Models\Products\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAll(mixed $request): LengthAwarePaginator;
    public function get(object $product): ?Product;
    public function uploadFile(object $product, object $fileRow): bool; 
    public function store(mixed $request): Product;
    public function update(mixed $request, object $product): ?Product;
    public function destroy(object $product): bool;
    public function deleteProductFiles(object $product): bool;
}
