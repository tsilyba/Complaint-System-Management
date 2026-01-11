<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List users (Admin) with optional search + pagination.
     *
     * Supported search:
     * - Exact match on ID
     * - Partial match on name
     * - Partial match on email
     */
    public function index(Request $request)
    {
        // Read optional query string: ?search=...
        $search = trim((string) $request->query('search', ''));

        $usersQuery = User::query();

        /**
         * Optional: Filter residents only
         * Uncomment ONE based on your schema.
         */
        // $usersQuery->where('is_admin', 0);
        // $usersQuery->where('role', 'resident');

        // Apply search only when user provided a value
        if ($search !== '') {
            $usersQuery->where(function ($q) use ($search) {
                // If the search is numeric, allow direct ID match
                if (ctype_digit($search)) {
                    $q->orWhere('id', (int) $search);
                }

                // Name/email partial match
                $q->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Order newest first and paginate results
        $users = $usersQuery
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Preserve ?search=... during pagination links

        // View: resources/views/admin/users.blade.php
        return view('admin.users', compact('users'));
    }

    /**
     * Show the edit form for a single user.
     */
    public function edit(User $user)
    {
        // View: resources/views/admin/users/edit.blade.php
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update an existing user.
     */
    public function update(Request $request, User $user)
    {
        // Validate input; keep email unique except for the current user
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            /**
             * Optional: Allow role updates (uncomment if needed)
             * 'role' => ['required', 'in:resident,admin'],
             */
        ]);

        /**
         * Optional: If role drives is_admin, sync it here.
         * Example:
         * $validated['is_admin'] = ($validated['role'] === 'admin') ? 1 : 0;
         */

        $user->update($validated);

        return redirect()
            ->route('admin.users') // Ensure route name matches your routes/web.php
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user record.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users') // Ensure route name matches your routes/web.php
            ->with('success', 'User deleted successfully.');
    }
}
