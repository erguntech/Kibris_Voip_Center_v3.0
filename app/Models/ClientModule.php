<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class ClientModule extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'client_modules';

    protected $fillable = [
        'client_id',
        'sms_module',
        'sms_module_device_id',
        'pbx_module',
        'pbx_server_ip_address',
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
                'client_id',
                'sms_module',
                'sms_module_device_id',
                'pbx_module',
                'pbx_server_ip_address',
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
        return $this->belongsTo(Client::class, 'client_id', 'id')->withTrashed();
    }

    public function linkedSMSDevice()
    {
        return $this->belongsTo(SMSDevice::class, 'sms_module_device_id', 'id');
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
