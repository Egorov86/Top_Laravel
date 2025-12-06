<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    public function index(UserRepository $repository)
    {
        $users = $repository->all();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $posts = $user->posts()->latest()->get();
        return view('users.show', compact('user', 'posts'));
    }

    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }


    public function updateProfile(UserUpdateRequest $request)
    {
        $this->service->updateProfile($request, Auth::id());
        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен!');
    }

    public function removeAvatar()
    {
        $this->service->removeAvatar(Auth::id());
        return redirect()->route('profile')->with('success', 'Аватарка успешно удалена!');
    }
}
