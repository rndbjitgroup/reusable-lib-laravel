<?php 

namespace App\Repositories\Users;

use App\Enums\CmnEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository 
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

    public function getAll($request)
    {
        return $this->user
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_text . '%')
                ->orWhere('email', 'like', '%' . $request->search_text . '%');
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
        return $this->user
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_text . '%')
                ->orWhere('email', 'like', '%' . $request->search_text . '%');
            });
        })->get(['id', 'name', 'email']);
    }

    public function get($user)
    {
        return $user;
    }

    public function store($request)
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);
        $user = $this->user->create($input);  
        $user->roles()->attach($request->roles ?? [CmnEnum::ROLE_USER_ID]);
        return $user->fresh();
    }

    public function update($request, $user)
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);
        $user->roles()->sync($request->roles ?? []); 
        return $user->fresh();
    }

    public function destroy($user)
    {
        return $user->delete();
    }
}