<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $usersQuery = User::query();

//search functionality
        if ($search !== '') {
            $usersQuery->where(function ($q) use ($search) {
                if (ctype_digit($search)) {
                    $q->orWhere('id', (int) $search);
                }

                $q->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery
            ->latest()
            ->paginate(10)
            ->withQueryString(); 
        return view('admin.users', compact('users'));
    }

  //edit
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    //update
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            
        ]);

       

        $user->update($validated);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User updated successfully.');
    }

   //delete
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users') 
            ->with('success', 'User deleted successfully.');
    }
}
