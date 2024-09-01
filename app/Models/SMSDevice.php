<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class SMSDevice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'sms_devices';

    protected $fillable = [
        'device_name',
        'phone_no',
        'gsm_api_token',
        'assigned_client_id',
        'credit_count',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->put('Causer Name', $activity->causer->getUserFullName());
        $activity->properties = $activity->properties->put('Log Type', $eventName);
        $activity->properties = $activity->properties->put('Log Subject', $activity->subject_type);
    }

    // Activity Logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'device_name',
                'phone_no',
                'gsm_api_token',
                'assigned_client_id',
                'credit_count',
                'is_active',
                'created_by',
                'updated_by',
                'deleted_by',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Model Connections
    public function linkedClient()
    {
        return $this->belongsTo(Client::class, 'assigned_client_id', 'id')->withTrashed();
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withTrashed();
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withTrashed();
    }

    public function deletedUser()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id')->withTrashed();
    }
}
