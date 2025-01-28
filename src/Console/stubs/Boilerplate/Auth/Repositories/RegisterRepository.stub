<?php 

namespace App\Repositories\Auth;

use App\Enums\CmnEnum;
use App\Interfaces\Auth\RegisterRepositoryInterface; 
use App\Models\User;

class RegisterRepository implements RegisterRepositoryInterface  
{
    /** 
     * @var User
     */
    protected $user;

    /** 
     * RegisterRepository constructor.
     * 
     * @param User $post 
     */

    function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function create($request): User 
    { 
        $user = $this->user->create($request->all());
        if(method_exists($user, 'roles')) { 
            $user->roles()->attach([CmnEnum::ROLE_USER_ID]);
        }
        return $user->fresh();
    }

}