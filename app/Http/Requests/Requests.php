<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Requests extends FormRequest
{    public function rules(): array
{
        return [
    'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
    'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
    'password' => 'nullable|string|min:6|confirmed',
    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];
    }
}
