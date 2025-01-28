<?php 

namespace App\Repositories\Users;

use App\Enums\CmnEnum;
use App\Interfaces\Users\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface 
{
    /** 
     * @var User
     */
    protected $user;

    /** 
     * UserRepository constructor.
     * 
     * @param User $post 
     */

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll($request): LengthAwarePaginator
    {
        return $this->user
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->searchText . '%')
                ->orWhere('email', 'like', '%' . $request->searchText . '%');
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
        return $this->user
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->searchText . '%')
                ->orWhere('email', 'like', '%' . $request->searchText . '%');
            });
        })->get(['id', 'name', 'email']);
    }

    public function get($user): ?User
    {
        return $user;
    }

    public function store($request): User
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);
        $user = $this->user->create($input);  
        $user->roles()->attach($request->roles ?? [CmnEnum::ROLE_USER_ID]);
        return $user->fresh();
    }

    public function update($request, $user): ?User
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);
        $user->update($input); 
        $user->roles()->sync($request->roles ?? []);
        return $user->fresh();
    }

    public function destroy($user): bool
    {
        return $user->delete();
    }
}