<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class UserSetting extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'user_settings';

    protected $fillable = [
        'user_id',
        'app_auto_logout_duration'
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
                'user_id',
                'app_auto_logout_duration',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Model Connections
    public function linkedUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
}
