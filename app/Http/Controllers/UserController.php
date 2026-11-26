<?php

namespace App\Http\Controllers;

use App\Http\Resources\DonateResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideoResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request, string $nickname) {
        $channel = User::where('nickname', $nickname)->first();
        return response()->json([
            "data" => [
                "profile" => [
                    "nickname" => $channel->nickname,
                    "avatar" => $channel->avatar,
                    "count_videos" => $channel->videos->count(),
                    "count_views" => $channel->videos->sum('views'),
                ],
                "videos" => VideoResource::collection($channel->videos),
                "per_page" => $channel->perPage(),
                "current_page" => $channel->currentPage(),
                "last_page" => $channel->currentPage(),
            ]
        ]);
    }
    public function registration(Request $request) {
            $data = $request->validate([
               "nickname" => "sometimes|string|unique:users|min:3",
               "email" => "required|email|unique:users",
               "avatar" => "sometimes|image|mimes:png|max:2560",
               "password" => "required|string|min:3",
               "birthdate" => "required|date|before_or_equal: -18 years",
            ]);
            if($request->input('nickname') == null) {
                $randomChars = ['а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з'];
                $randomDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $result = '';
                for($i = 0; $i < 3; $i++) {
                    $result .= $randomChars[array_rand($randomChars)] . $randomDigits[array_rand($randomDigits)];
                }
                $data['nickname'] = $result;
            }
            $imagePath = null;
            if($request->hasFile('avatar')) {
                $imagePath = $request->file('avatar')->store('avatars', 'public');
            }
            $user = User::create([
                'nickname' => $data['nickname'],
                'email' => $data['email'],
                'password' => $data['password'],
                'birthdate' => new \DateTimeImmutable($data['birthdate'])->format('Y-m-d'),
                'avatar' => $imagePath,
            ]);
            $token = Str::uuid();
            $user->update(["token" => $token]);
            return response()->json([
                "data" => [
                    "user" => new UserResource($user),
                    "credentials" => [
                        "token" => $token,
                    ]
                ]
            ], 201);
    }
    public function login(Request $request) {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required|min:3"
        ]);
        if(Auth::attempt($data)) {
            $token = Str::uuid();
            $user = \auth()->user();
            $user->update(["token" => $token]);
            return response()->json([
                "credentials" => [
                    "token" => $token,
                ]
            ], 200);
        } else {
            return response()->json([
                "message" => "unauthorized",
                "code" => 401
            ], 401);
        }
    }

    public function logout(Request $request) {
        $user = \auth()->user();
        $user->update(["token" => null]);
        Auth::logout();
        return response()->noContent();
    }

    public function me(Request $request) {
        $user = auth()->user();
        return response()->json([
            "data" => [
                "profile" => [
                    "nickname" => $user->nickname,
                    "avatar" => $user->avatar,
                    "count_videos" => $user->videos->count(),
                    "count_views" => $user->videos->sum('views'),
                    "balance" => $user->donations->sum('sum'),
                ],
                "videos" => VideoResource::collection($user->videos)->additional([
                    "withStatus" => true
                ]),
                "donations" => DonateResource::collection($user->donations)
            ]
        ]);
    }
}
