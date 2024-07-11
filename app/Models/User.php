<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeFilter($query, $request)
    {
        foreach ($request->all() as $key => $val) {
            if ($key === 'perPage' || $key === 'page') {
            } else {
                if ($request->has($key)) {
                    if ($val !== null) {
                        switch ($key) {
                                // case 'country':
                                // $query->whereHas('country', function ($query) use ($val) {
                                //     $query->where('name', 'like', '%' . $val . '%');
                                // });
                                // break;
                            default:
                                $query->where($key, 'like', '%' . $val . '%');
                                break;
                        }
                    }
                }
            }
        }

        return $query;
    }
}
