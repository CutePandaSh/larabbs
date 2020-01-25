<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $captchaData = \Cache::get($request->captcha_key);
        if (!$captchaData) {
            abort(403, '图片验证码已过期');
        }

        if (!hash_equals($captchaData['captcha'], strtolower($request->captcha_code))) {
            \Cache::forget($request->captcha_key);
            throw new AuthorizationException('验证码错误');
        }

        $phone = $captchaData['phone'];

        if (app()->environment('production')){

            $code = str_pad(random_int(0, 9999), 4 , 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone, [
                    'template' => config('easysms.gateways.aliyun.templates.register'),
                    'data' => [
                        'code' => $code,
                    ],
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('aliyun')->getMessage();
                abort(500, $message ?: '短信发送异常');
            }

        } else {
            $code = '1234';
        }

        $key = 'verificationCode_' . Str::random(15);
        $expiredAt = now()->addMinutes(5);

        \Cache::put($key, ['phone'=>$phone, 'code'=>$code], $expiredAt);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ]);
    }
}
