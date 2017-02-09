<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionHistory extends Model
{
    protected $fillable = [
    	'user_id',
    	'action',
    	'session_id',
    ];

    public $timestamps = true;

    public static function recordLogin($user)
    {
    	self::recordAction($user, 'login');
    }

    public static function recordLogout($user)
    {
    	self::recordAction($user, 'logout');
    }

    public static function recordAction($user, $action)
    {
    	self::create([
    		'user_id' => $user->id,
    		'action' => $action,
    		'session_id' => session()->getId(),
    	]);
    }
}
