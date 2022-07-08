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
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_text . '%')
                ->orWhere('detail', 'like', '%' . $request->search_text . '%');
            });
        })  
        ->when($request->start_date, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->start_date);
        })
        ->when($request->end_date, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->end_date);
        })
        ->latest()
        ->paginate(config('constants.paginate'));
    }

    public function list($request) 
    {
        return $this->sample
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_text . '%')
                ->orWhere('detail', 'like', '%' . $request->search_text . '%');
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