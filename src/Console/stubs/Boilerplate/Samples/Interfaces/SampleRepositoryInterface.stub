<?php

namespace App\Interfaces\Samples;

use App\Models\Samples\Sample;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SampleRepositoryInterface
{
    public function getAll(mixed $request): LengthAwarePaginator;
    public function list(mixed $request): Collection;
    public function get(object $sample): ?Sample; 
    public function store(mixed $request): Sample;
    public function update(mixed $request, object $sample): ?Sample;
    public function destroy(object $sample): bool; 
}
