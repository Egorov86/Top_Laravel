<?php

namespace App\Http\Controllers\Web;

use App\Events\UserRegistered;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private UserService    $userService,
    ){}

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $registerRequest): RedirectResponse
    {
        $validator = $registerRequest->validated();

        $user = $this->userRepository->store($validator['username'], $validator['email'], $validator['password']);
        event(new UserRegistered($user));

        return redirect()->route('posts.index');
    }

    public function login(Request $request): RedirectResponse
    {
        return $this->userService->login($request);
    }

    public function logout(Request $request): RedirectResponse
    {
        return $this->userService->logout($request);
    }

    public function showResetPassword(): View
    {
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        return $this->userService->resetPassword($request);
    }

    public function userPasswordReset(Request $request, User $user, string $hash): View
    {
        return $this->userService->userPasswordReset($request, $user, $hash);
    }

    public function changePassword(Request $request, User $user): RedirectResponse
    {
        return $this->userService->changePassword($request, $user);
    }
}
