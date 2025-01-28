<?php

namespace App\Interfaces\Products;

use App\Models\Products\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

interface ProductCategoryRepositoryInterface
{
    public function getAll(mixed $request): Collection;
    public function get(object $productCategory): ?ProductCategory;
    public function uploadFile(object $productCategory, object $fileRow): bool;
    public function store(mixed $request): ProductCategory;
    public function update(mixed $request, object $productCategory): ?ProductCategory;
    public function destroy(object $productCategory): bool;
    public function destroyProductCategoryFile(mixed $request, object $productCategory): bool;
}
