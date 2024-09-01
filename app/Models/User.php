<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles, CausesActivity;
    protected function getDefaultGuardName(): string { return 'web'; }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'client_id',
        'user_type',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getUserFullName(){
        return $this->first_name.' '.$this->last_name;
    }

    // Model Connections
    public function linkedClient()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id')->withTrashed();
    }

    public function linkedEmployee()
    {
        return $this->belongsTo(Employee::class, 'id', 'user_id')->withTrashed();
    }
}
