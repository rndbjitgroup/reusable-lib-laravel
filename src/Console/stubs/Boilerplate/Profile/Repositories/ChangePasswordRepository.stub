<?php 

namespace App\Repositories\Profile;

use App\Interfaces\Profile\ChangePasswordRepositoryInterface;
use App\Models\User; 

class ChangePasswordRepository implements ChangePasswordRepositoryInterface
{
    /** 
     * @var User
     */
    protected $user;

    /** 
     * LoginRepository constructor.
     * 
     * @param User $user 
     */

    function __construct(User $user)
    {
        $this->user = $user;
    } 

    public function update($request, $user): bool
    { 
        return $user->update($request->all()); 
    }

}