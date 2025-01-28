<?php 

namespace App\Repositories\Samples;

use App\Interfaces\Samples\SampleRepositoryInterface;
use App\Models\Samples\Sample;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SampleRepository implements SampleRepositoryInterface
{
    /** 
     * @var Sample
     */
    protected $sample;

    /** 
     * LoginRepository constructor.
     * 
     * @param Sample $post 
     */

    function __construct(Sample $sample)
    {
        $this->sample = $sample;
    }

    public function getAll($request): LengthAwarePaginator
    {
        return $this->sample
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->searchText . '%')
                ->orWhere('detail', 'like', '%' . $request->searchText . '%');
            });
        })   
        ->when($request->startDate, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->startDate);
        })
        ->when($request->endDate, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->endDate);
        })
        ->latest()
        ->paginate(config('constants.paginate'));
    }

    public function list($request): Collection 
    {
        return $this->sample
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->searchText . '%')
                ->orWhere('detail', 'like', '%' . $request->searchText . '%');
            });
        }) ->get(['id', 'name']);
    }

    public function get($sample): ?Sample
    {
        return $sample;
    }

    public function store($request): Sample
    {
        return $this->sample->create($request->validated());
    }

    public function update($request, $sample): ?Sample
    {
        $sample->update($request->all());
        return $sample->fresh();
    }

    public function destroy($sample): bool
    {
        return $sample->delete();
    }

}