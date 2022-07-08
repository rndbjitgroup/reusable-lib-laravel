<?php 

namespace App\Services\Users;

use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserListCollection;
use App\Http\Resources\Users\UserResource;
use App\Repositories\Users\UserRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserService 
{
    use RespondsWithHttpStatus;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserService constructor. 
     * 
     * @param UserRepository $userRepository
     */

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new UserCollection($this->userRepository->getAll($request)));
    }

    public function list($request)
    {
        return $this->success('', new UserListCollection($this->userRepository->list($request)));
    }

    /**
     * Get user by id.
     *
     * @param $id
     * @return String
     */
    public function get($user)
    {
        return $this->success('', new UserResource($user));
    }

    /**
     * Validate user data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function store($request)
    {
        $result = $this->userRepository->store($request);
        if($result) {
            return $this->success(__('messages.crud.stored'), new UserResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

     
    /**
     * Update user data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $user)
    {
        $result = $this->userRepository->update($request, $user);
        if($result) {
            return $this->success(__('messages.crud.updated'), new UserResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete user by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($user)
    {
        $result = $this->userRepository->destroy($user);
        if($result) {
            return $this->success(__('messages.crud.deleted')); 
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }
}