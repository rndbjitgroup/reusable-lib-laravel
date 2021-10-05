<?php 

namespace App\Repositories\Profile;

use App\Models\User;
use Illuminate\Support\Str;

class ProfileRepository
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

    public function update($request, $user)
    {
        $user->update($request->all());
        return $user->fresh();
    }

}