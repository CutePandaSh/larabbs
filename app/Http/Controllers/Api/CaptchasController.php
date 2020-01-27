<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Str;
use App\Http\Requests\Api\CaptchasRequest;

class CaptchasController extends Controller
{
    public function store(CaptchasRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-' . Str::random(15);
        $phone = $request->phone;

        $captcha = $captchaBuilder->build();
        // $folder = 'captcha';
        // $captcha->save(public_path() . '/' . $folder . '/' . $key .'.jpg');

        $expiredAt = now()->addMinutes(2);
        \Cache::put($key, ['phone'=>$phone, 'captcha'=>strtolower($captcha->getPhrase())], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline(),
            'captcha_code' => ! app()->isLocal() ? null : $captcha->getPhrase(),
            // 'captcha_url' => config('app.url') . "/$folder/$key.jpg",

        ];
        return response()->json($result)->setStatusCode(201);
    }
}
