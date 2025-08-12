<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with(['roles:id,title'])->get();
      

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|max:255|min:4',
            'email' => 'bail|required|email|unique:users|max:255',
            'password' => 'bail|required|min:6',
            'ip_address' => 'bail|required',
        ]);
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index')->withStatus(__('User is added successfully.'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();

        $user->load('roles');

        // $tokens = $user->tokens()->get()->pluck('token');
        
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'bail|required|max:255|min:4',
            'ip_address' => 'bail|required',
        ]);
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index')->withStatus(__('User is updated successfully.'));
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back()->withStatus(__('User is deleted successfully.'));;;
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function updateProfile(Request $request)
    {
        auth()->user()->update([
            'name' => $request->name,
        ]);
        return back()->withStatus(__('Profile is updated successfully.'));;;
    }
    public function password(PasswordRequest $request)
    {

        auth()->user()->update(['password' => $request->get('password')]);

        return back()->withStatus(__('Password successfully updated.'));
    }

    public function createBranchApiToken(Request $request) {

        $user = User::where('id',$request->id)->first();
        $user->tokens()->delete();
        $authToken = $user->createToken('auth-token')->plainTextToken;
        return back()->with('token', $authToken);
    }
}
