<?php 

namespace App\Repositories\Blogs;

use App\Models\Blogs\Category;

class CategoryRepository
{
    /** 
     * @var Category
     */
    protected $category;

    /** 
     * LoginRepository constructor.
     * 
     * @param Category $category 
     */

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll($request)
    {
        return $this->category
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search_text . '%')
                ->orWhere('slug', 'like', '%' . $request->search_text . '%');
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

    public function get($category)
    {
        return $category;
    }

    public function store($request)
    {
        $category = $this->category->create($request->all());
        return $category->fresh();
    }

    public function update($request, $category)
    {
        $category->update($request->all());
        return $category->fresh();
    }

    public function destroy($category)
    {
        return $category->delete();
    }

}