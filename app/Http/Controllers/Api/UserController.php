<?php

namespace CodeShopping\Http\Controllers\Api;

use CodeShopping\Http\Resources\UserResource;
use CodeShopping\User;
use Illuminate\Http\Request;
use CodeShopping\Http\Requests\UserRequest;
use CodeShopping\Http\Controllers\Controller;
use Illuminate\database\Eloquent\Builder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();
        $query = $this->onlyTrashedIfRequested($request,$query);
        $users = $query->paginate(10);
        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeShopping\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \CodeShopping\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CodeShopping\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CodeShopping\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([], 204);
    }

    public function restore (User $user){
        $user->restore();
        return response()->json([],204);
    }

    private function onlyTrashedIfRequested(Request $request, Builder $query){
        if($request->get('trashed')== 1){
            $query = $query->onlyTrashed();
        }
        return $query;
    }
}
