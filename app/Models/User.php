<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'username',
        'email',
        'phone',
        'password',
        'role',
        'permission',
        'is_active',
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

    /**
     * وګورئ چې کاروونکي ته یو ځانګړی واک (Permission) ورکړل شوی دی که نه.
     *
     * @param string $permissionName د واک نوم (لکه 'ads', 'packages', 'services', 'destinations')
     * @return bool
     */
    public function hasPermissionTo($permissionName)
    {
        // که کاروونکی Admin وي، نو ټولو واکونو ته لاسرسی لري
        if ($this->role === 'admin') {
            return true;
        }

        // که کاروونکی Staff وي، نو یوازې خپل ټاکل شوی واک لري
        if ($this->role === 'staff') {
            // که Staff ته هیڅ واک نه وي ورکړل شوی، نو false
            if (empty($this->permission)) {
                return false;
            }
            // که د Staff واک د غوښتل شوي واک سره سمون خوري، نو true
            return $this->permission === $permissionName;
        }

        // که کاروونکی نور رولونه ولري (لکه 'user')، نو هیڅ واک نلري
        return false;
    }
}