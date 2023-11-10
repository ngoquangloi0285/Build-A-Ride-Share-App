<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginNeedsVerfication;
use Illuminate\Http\Request;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        // Validate the phone number
        $request->validate([
            'phone' => 'required|numeric|min:10',
        ]);

        // Format the phone number to include the country code
        $formattedPhone = '+84' . ltrim($request->phone, '0');

        // Find or create a user model
        $user = User::firstOrCreate([
            'phone' => $formattedPhone
        ]);

        if (!$user) {
            return response()->json(['message' => 'Không thể xử lý người dùng với số điện thoại này.', 401]);
        }

        $loginCode = rand(111111, 999999);

        $user->update([
            'login_code' => $loginCode
        ]);

        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $phone = getenv("TWILIO_FROM");

        $twilio = new Client($sid, $token);

        try {
            $twilio->messages
                ->create(
                    $formattedPhone, // to
                    [
                        "body" => "Mã đăng nhập RideShare của bạn là: " . $loginCode . ". Vui lòng không chia sẻ mã này cho bất kỳ ai",
                        "from" => $phone
                    ]
                );

            // Nếu tin nhắn gửi thành công
            return response()->json(['message' => 'Thông báo SMS đã được gửi.']);
        } catch (RestException $e) {
            // Xử lý lỗi từ Twilio
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();

            if ($errorCode === 21610) {
                $user->delete();
                // Lỗi: Số điện thoại chưa được xác minh
                return response()->json(['error' => 'Số điện thoại chưa được xác minh.', 401]);
            } else {
                // Xử lý các lỗi khác từ Twilio nếu cần
                $user->delete();
                return response()->json(['error' => $errorMessage, 401]);
            }
        }
    }



    public function verify(Request $request)
    {
        // validate the incoming request
        $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:111111,999999'
        ]);

        // Format the phone number to include the country code
        $formattedPhone = '+84' . ltrim($request->phone, '0');

        // find the user
        $user = User::where('phone', $formattedPhone)
            ->where('login_code', $request->login_code)
            ->first();

        // is the code provided the same one saved

        // if so, return back an auth token 
        if ($user) {
            $user->update([
                'login_code' => null
            ]);

            return response()->json([
                "message" => "Successfully",
                "token" => $user->createToken($request->login_code)->plainTextToken
            ]);
        }
        // if not, return back a message
        return response()->json(['message' => 'Invalid verification code.', 401]);
    }
}
