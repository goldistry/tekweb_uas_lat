<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Utils\HttpResponseCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    protected $adminController;
    protected $userController;
    public function __construct()
    {
        $this->adminController = new AdminController(new Admin());
        $this->userController = new UserController(new User());
    }

    public function loginAdmin(Request $request)
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.logout');  // Redirect to the admin dashboard if already logged in
        }
        // Validate the inputs
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        // dd($credentials);

        // Check if the admin credentials are correct
        $admin = Admin::where('username', $request->username)->first();
        if (!$admin) {
            return redirect()->route('admin.login')->withErrors('Invalid username or password.');
        }
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Successful login, set the session
            session(['admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }

        // If credentials are invalid, redirect back with an error message
        return redirect()->route('admin.login')->withErrors('Invalid username or password.');
    }
    public function logout()
    {
        // session()->forget('admin_id');
        // Clear all session data
        session()->flush();

        // Redirect to the login page or any page you prefer
        return redirect()->route('admin.login');
    }



    public function signUp(Request $request)
    {
        // Cek email udh ada apa blm
        $user = $this->userController->model::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['ok' => false, 'message' => 'There is an account with this email already'], HttpResponseCode::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json(['ok' => false, 'message' => $validator->errors()->first()], HttpResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validated = $validator->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = $this->userController->create($validated);

        return response()->json(['ok' => true, 'message' => 'Registration successful!'], HttpResponseCode::HTTP_OK);
    }


    public function login(Request $request)
    {
        $user = $this->userController->model::where("email", $request->usernameOrEmail)->orWhere("username", $request->usernameOrEmail)->first();
        if (!$user) {
            return $this->error("There is no account associated with the username or email you provided!", HttpResponseCode::HTTP_NOT_FOUND);
        }
        // dd($request);
        if (!Hash::check($request->password, $user->password)) {
            return $this->error("Wrong password!", HttpResponseCode::HTTP_UNAUTHORIZED);
        }
        $user->tokens()->delete();
        $userToken = $user->createToken('user_token', ['user'])->plainTextToken;
        return $this->success(
            'Login success!',
            [
                'id' => $user->id,
                'name' => $user->username,
                'email' => $user->email,
                'token' => $userToken,
            ]
        );
    }
}
