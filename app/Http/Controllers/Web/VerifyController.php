<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyController
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! $request->hasValidSignature()) {
            return response()->json(['message' => 'Invalid or expired link'], 400);
        }

        if ($hash !== sha1($user->email)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }
}
