<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
class ProfileController extends Controller
{
    public function me(Request $request)
{
    return response()->json([
        'message' => 'Profile fetched successfully',
        'data' => $request->user()
    ], 200);
}


}
