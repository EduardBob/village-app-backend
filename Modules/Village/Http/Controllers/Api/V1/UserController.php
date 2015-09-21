<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\User;
use Modules\Village\Packback\Transformer\UserTransformer;

class UserController extends ApiController
{
//    /**
//     * Get all users
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        $users = User::all()->load(['building']);
//
//        return $this->response->withCollection($users, new UserTransformer);
//    }
//    /**
//     * Get a single user
//     *
//     * @param $userId
//     * @return Response
//     */
//    public function show($userId)
//    {
//        $user = User::find($userId);
//        if(!$user){
//            return $this->response->errorNotFound('Not Found');
//        }
//
//        return $this->response->withItem($user, new UserTransformer);
//    }

//    /**
//     * Store a user
//     *
//     * @return Response
//     */
//    public function store()
//    {
//        $input = Input::only('email', 'name', 'password');
//        $user = User::create($input);
//
//        return $this->response->withItem($user, new UserTransformer);
//    }
//
//    /**
//     * Update a user
//     *
//     * @param $userId
//     * @return Response
//     */
//    public function update($userId)
//    {
//        $input = Input::only('email', 'name', 'password');
//        $user = User::find($userId);
//        if(!$user){
//            return $this->response->errorNotFound('Not Found');
//        }
//
//        $user->update($input);
//
//        return $this->response->withItem($user, new UserTransformer);
//    }
//    /**
//     * Delete a user
//     *
//     * @param $userId
//     * @return Response
//     */
//    public function destroy($userId)
//    {
//        $user = User::find($userId);
//        if(!$user){
//            return $this->response->errorNotFound('Not Found');
//        }
//
//        // Remove all book relationships
////        $user->books()->sync([]);
//        $user->delete();
//
//        return Response::json([
//            'success' => true
//        ]);
//    }
}