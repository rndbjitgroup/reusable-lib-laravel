<?php 

namespace App\Repositories\Samples;

use App\Models\Samples\Sample;

class SampleRepository
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

    public function getAll($request)
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

    public function list($request) 
    {
        return $this->sample
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->searchText . '%')
                ->orWhere('detail', 'like', '%' . $request->searchText . '%');
            });
        }) ->get(['id', 'name']);
    }

    public function get($sample)
    {
        return $sample;
    }

    public function store($request)
    {
        return $this->sample->create($request->validated());
    }

    public function update($request, $sample)
    {
        $sample->update($request->all());
        return $sample->fresh();
    }

    public function destroy($sample)
    {
        return $sample->delete();
    }

}