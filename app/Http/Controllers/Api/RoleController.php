<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleGetAvailableRolesByGroupRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * RoleController constructor.
     *
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = Role::all();

        if (isset($roles)) {
            return response($roles, Response::HTTP_OK);
        } else {
            return response("Roles not found!", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $role = new Role;

        if (isset($role)) {
            $role->name = $request->input("name");
            $role->display_name = $request->input("display name");
            $role->description = $request->input("description");
            $role->created_at = date('Y-m-d H:i:s');
            $role->updated_at = date('Y-m-d H:i:s');

            if ($role->save()) {
                return response($role, Response::HTTP_OK);
            }
        }

        return response("Role has not been created!", Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (isset($role)) {
            return response($role, Response::HTTP_OK);
        } else {
            return response("Role not found!", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @return Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role    $role
     *
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        $role = Role::find($request->input("id"));

        if (isset($role)) {
            $role->name = $request->input("name");
            $role->display_name = $request->input("display name");
            $role->description = $request->input("description");
            $role->updated_at = date('Y-m-d H:i:s');

            if ($role->save()) {
                return response($role, Response::HTTP_OK);
            }
        }

        return response("Role not found!", Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role->delete()) {
            return response("Role has been deleted!", Response::HTTP_OK);
        } else {
            return response("Role has not been deleted!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param RoleGetAvailableRolesByGroupRequest $request
     *
     * @return Response
     */
    public function getAvailableRolesByGroups(RoleGetAvailableRolesByGroupRequest $request): Response
    {
        try {
            $roles = $this->roleRepository->getAvailableRolesByGroups($request->input('groups') ?? []);
            return response($roles, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
