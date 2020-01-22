<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        $field = $this->getHashField();

        // dd(Redis::hGetAll($hash));
        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash, $field, $now);
    }

    public function getLastActivedAtAttribute($value)
    {
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        $field = $this->getHashField();

        $datetime = Redis::hGet($hash, $field) ? : $value;

        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }
    }

    public function syncUserActivedAt()
    {
        $yesterday_date = Carbon::yesterday()->toDateString();

        $hash = $this->getHashFromDateString($yesterday_date);

        $datas = Redis::hGetAll($hash);

        foreach ($datas as $user_id => $actived_at) {
            $user_id = str_replace($this->field_prefix, '', $user_id);

            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->timestamps = false;
                $user->save();
            }
        }

        Redis::del($hash);
    }

    protected function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    protected function getHashField()
    {
        return $this->field_prefix . $this->id;
    }

}
