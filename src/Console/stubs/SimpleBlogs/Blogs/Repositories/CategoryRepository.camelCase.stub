<?php 

namespace App\Repositories\Blogs;

use App\Interfaces\Blogs\CategoryRepositoryInterface;
use App\Models\Blogs\Category;
use Illuminate\Database\Eloquent\Collection; 

class CategoryRepository implements CategoryRepositoryInterface
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

    public function getAll($request): Collection
    {
        return $this->category
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->searchText . '%')
                ->orWhere('slug', 'like', '%' . $request->searchText . '%');
            });
        }) 
        ->when($request->start_date, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->start_date);
        })
        ->when($request->end_date, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->end_date);
        })
        ->latest()
        ->get();
    } 

    public function get($category): ?Category
    {
        return $category;
    }

    public function store($request): Category
    {
        $category = $this->category->create($request->all());
        return $category->fresh();
    }

    public function update($request, $category): ?Category
    {
        $category->update($request->all());
        return $category->fresh();
    }

    public function destroy($category): bool
    {
        return $category->delete();
    }

}