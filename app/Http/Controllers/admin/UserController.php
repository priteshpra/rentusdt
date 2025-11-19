<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * index — list users (aka "list")
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $users = $this->userService->list($perPage);

        // today's registered users
        $todayUsers = User::whereDate('created_at', Carbon::today())->get();

        return view('admin.users', compact('users', 'todayUsers'));
    }

    /**
     * Show Add User Form
     */
    public function create()
    {
        $user = [];
        return view('admin.edit-user', compact('user'));
    }

    /**
     * show — display a single user
     */
    public function show($id)
    {
        $user = $this->userService->find($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * edit — show edit form for user
     */
    public function edit($id)
    {
        $user = $this->userService->find($id);

        return view('admin.edit-user', compact('user'));
    }

    /**
     * Store New User
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'contact'  => 'required|digits_between:10,15',
            'password' => 'required|min:6',
            'status'   => 'required|in:0,1',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'contact'  => $request->contact,
            'password' => bcrypt($request->password),
            'status'   => $request->status,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User added successfully!');
    }

    /**
     * update — validate and update the user
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'contact' => ['required', 'digits:10'],
        ];

        $validated = $request->validate($rules);
        $user = $this->userService->update($id, $validated);

        return redirect()
            ->route('admin.users.edit', $user->id)
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // find user
        $user = $this->userService->find($id);

        $this->userService->update($id, ['is_deleted' => 1]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function assignRate(Request $request, $id)
    {
        // Validate request
        $validated = $request->validate([
            'assign_rate' => 'required|numeric|min:1|max:100',
        ]);

        // Call service to update
        $user = $this->userService->assignRate($id, $validated['assign_rate']);

        // Return AJAX JSON response
        return response()->json([
            'status'  => 'success',
            'message' => 'Return rate updated successfully.',
            'data'    => [
                'id'          => $user->id,
                'assign_rate' => $user->assign_rate,
            ]
        ], Response::HTTP_OK);
    }
}
