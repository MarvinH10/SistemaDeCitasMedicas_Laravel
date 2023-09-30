<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Appointment extends Model
{
    protected $fillable = [
    	'employer_id',
    	'patient_id',
    	'scheduled_date',
    	'scheduled_time',
        'promotion_id',
    	'name',
        'dni',
        'edad',
        'phone'
    ];

    protected $hidden = [
        'promotion_id', 'employer_id', 'scheduled_time'
    ];

    protected $appends = [
        'scheduled_time_12'
    ];

    public function promotion()
    {
    	return $this->belongsTo(Promotion::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class);
    }

    public function cancellation()
    {
        return $this->hasOne(CancelledAppointment::class);
    }

    public function getScheduledTime12Attribute() {
        return (new Carbon($this->scheduled_time))
            ->format('g:i A');
    }

    static public function createForPatient(Request $request, $patientId) {
        $data = $request->only([
            'employer_id',
            'patient_id',
            'scheduled_date',
            'scheduled_time',
            'promotion_id',
            'name',
            'dni',
            'edad',
            'phone'
        ]);

        $data['patient_id'] = $patientId;

        // right time format
        $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');

        return self::create($data);
    }
}
