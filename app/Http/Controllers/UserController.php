<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Role;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Traits\UserTrait;

class UserController extends Controller
{
    use UserTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('viewAny', User::class)) {
            $users = User::withTrashed()->where('role_id', '<', 3)->orderBy('id', 'desc')->get();
            $user_type = 'Customer';
            return view('admin_def.pages.user_index', compact('users', 'user_type'));
        } else {
            return view403();
        }
    }

    public function admin()
    {
        if (\Auth::user()->can('viewAnyAdmin', User::class)) {
            $users = User::where('role_id', '>=', 3)->get();
            $user_type = 'Admin';
            return view('admin_def.pages.user_admin_index', compact('users', 'user_type'));
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
    public function store(UserRegisterRequest $request)
    {
        $request->validated();
        try {
            $request['remember_token'] = \Str::random(16);
            $request['password'] = \Hash::make($request->password);
            $user = User::create($request->all());
            if ($user->save()) {
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $is_allowed = (
            (!$user->isAdmin() && \Auth::user()->can('view', User::class))
            || ($user->isAdmin() && \Auth::user()->can('viewAdmin', User::class))
            || \Auth::user()->can('userOwn', $user)
        );
        if ($is_allowed) {
            $orders = $this->getOrders($user, false);
            $bills = $orders->where('status', Order::STT['completed']);
            $roles = Role::whereNotIn('id', [User::ROLE['unactived'], User::ROLE['superadmin']])->get();
            return view('admin_def.pages.user_show', compact('user', 'orders', 'bills', 'roles'));
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
        $user = User::findOrFail($id);
        return view('admin_def.pages.user_edit', compact('user'));
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
        switch ($request->action) {
            case 'active':
                $update_flag = $this->activeUser($id);
                break;
            case 'change-role':
                $update_flag = $this->changeRole((int)$request->role_id, $id);
                break;
            case 'ban':
                $update_flag = $this->banUser($id);
                break;
            case 'restore':
                $update_flag = $this->restoreUser($id);
                break;
        }

        if ($update_flag) {
            return redirect()->route('admin.user.index')->withMessage('OK');
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

    public function updateProfile(UpdateProfileRequest $request, $id)
    {
        $request->validated();

        $user = User::find($id);
        $user->fill($request->all());
        if ($user->isDirty()) {
            try {
                $user->save();
                return redirect()->route('admin.user.show', $id)->withMessage('ok');
            } catch (\Exception $e) {
            }
        }
        return redirect()->back();
    }

    public function activeUser($id)
    {
        $user = User::find($id);
        $update_flag = $user->update([
            'role_id' => User::ROLE['default'],
            'activated_at' => now(),
        ]);
        return $update_flag;
    }

    public function changeRole(int $role_id, $id)
    {
        $user = User::find($id);
        $update_flag = $user->update([
            'role_id' => $role_id,
        ]);
        return $update_flag;
    }

    public function banUser($id)
    {
        $this->authorize('update', User::class);
        $user = User::find($id);
        $update_flag = $user->delete();
        return $update_flag;
    }

    public function restoreUser($id)
    {
        $this->authorize('update', User::class);
        $user = User::onlyTrashed()->find($id);
        $update_flag = $user->restore();
        return $update_flag;
    }
}
