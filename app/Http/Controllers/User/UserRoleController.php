<?php

namespace App\Http\Controllers\User;

use App\Models\User\Role;
use Illuminate\Http\Request;
use App\Models\User\Employee;
use Illuminate\Support\Facades\DB;
use App\Transformers\Role\RoleTransformer;
use App\Http\Requests\UserRole\StoreRequest;
use App\Http\Controllers\GlobalController as Controller;
use App\Http\Requests\UserRole\DestroyRequest;
use App\Http\Requests\UserRole\IndexRequest;

class UserRoleController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.request:' . RoleTransformer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request, Employee $user)
    {
        $roles = $user->roles()->get();

        return $this->showAll($roles, RoleTransformer::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Employee $user)
    {
        DB::transaction(function () use ($request, $user) {
            $user->roles()->syncWithoutDetaching($request->role_id);
        });

        return $this->showOne(Role::findOrFail($request->role_id), 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, Employee $user, Role $role)
    {
        DB::transaction(function () use ($role, $user) {

            $user->roles()->detach($role->id);
        });

        return $this->message(['data' =>
            ['message' => "El permiso ha sido revocado"]
        ], 200);
    }
}