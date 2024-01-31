<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * [GET] :  Admin user List page for Super Admin
     */
    public function index()
    {
        try {
            $users = User::where('user_role_id', 1)->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.user.index', ['users' => $users]);
    }

    /**
     * [GET] :  Admin user create page for Super Admin
     */
    public function create()
    {
        return view('superadmin.user.create');
    }

    /**
     * [POST] :  Admin user create handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "first_name"  => "required|string|max:255",
            "last_name"  => "required|string|max:255",
            "email"  => "required|email|unique:users",
            "password" => "required|string|max:255"
        ]);

        try {
            $values['password'] = bcrypt($values['password']);
            $values['user_role_id'] = 1;

            User::create($values);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('super.users.index')->with('success', 'Admin user has been created successfully');
    }

    /**
     * [GET] :  Admin user edit page for Super Admin
     */
    public function edit(User $user)
    {
        return view('superadmin.user.edit', ['user' => $user]);
    }

    /**
     * [PUT] :  Admin user update handler for Super Admin
     */
    public function update(Request $request, User $user)
    {
        $values = $request->validate([
            "first_name"  => "required|string|max:255",
            "last_name"  => "required|string|max:255",
            "email"  => "required|email|unique:users,email," . $user->id,
            "password" => "nullable|string|max:255"
        ]);

        try {
            if ($values['password']) {
                $values['password'] = bcrypt($values['password']);
            }

            $user->update($values);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('super.users.index')->with('success', 'Admin user has been updated successfully');
    }

    /**
     * [DELETE] :  Admin user delete handler for Super Admin
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('super.users.index')->with('success', 'Admin user has been deleted successfully');
    }
}
