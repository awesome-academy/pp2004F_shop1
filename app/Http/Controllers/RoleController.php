<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleFormRequest;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manageRole', Role::class)) {
            $roles = Role::withTrashed()->get();
            return view('admin_def.pages.role_index', compact('roles'));
        } else {
            return view403();
        }
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
    public function store(RoleFormRequest $request)
    {
        $this->authorize('manageRole', Role::class);
        $request->validated();

        $role_flag = Role::create($request->all())->save();
        if ($role_flag) {
            return redirect()->route('admin.role.index');
        }
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->can('manageRole', Role::class)) {
            $role = Role::withTrashed()->find($id);
            $permissions = Permission::all()->except([1, 2]);
            return view('admin_def.pages.role_show', compact('role', 'permissions'));
        } else {
            return view403();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('manageRole', Role::class)) {
            $role = Role::withTrashed()->find($id);
            $permissions = Permission::all()->except([1, 2]);
            return view('admin_def.pages.role_edit', compact('role', 'permissions'));
        } else {
            return view403();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('manageRole', Role::class);
        $role = Role::find($id);
        $request['role_permission'] = implode(',', array_keys($request->permissions));
        $role->fill($request->all());
        if ($role->save()) {
            return redirect()->route('admin.role.show', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
