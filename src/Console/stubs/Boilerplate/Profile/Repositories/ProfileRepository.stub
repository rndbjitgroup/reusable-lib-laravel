<?php 

namespace App\Repositories\Profile;

use App\Interfaces\Profile\ProfileRepositoryInterface;
use App\Models\User; 

class ProfileRepository implements ProfileRepositoryInterface
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

    public function update($request, $user): ?User
    {
        $user->update($request->all());
        return $user->fresh();
    }

}