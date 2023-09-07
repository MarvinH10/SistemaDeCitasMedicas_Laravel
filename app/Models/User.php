<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Http;

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
        'address',
        'phone',
        'role',
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

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class)->withTimestamps();
    }

    public function scopePatients($query){
        return $query->where('role', 'paciente');
    }

    public function scopeEmployers($query){
        return $query->where('role', 'empleado');
    }

    public function asEmployerAppointments()
    {
        return $this->hasMany(Appointment::class, 'employer_id');
    }

    public function attendedAppointments()
    {
        return $this->asEmployerAppointments()->where('status', 'Atendida');
    }

    public function cancelledAppointments()
    {
        return $this->asEmployerAppointments()->where('status', 'Cancelada');
    }

    public function asPatientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function sendFCM($message)
    {
        if (!$this->device_token) {
            return;
        }

        $serverKey = 'your_firebase_server_key';
        $recipientToken = $this->device_token;

        $data = [
            'to' => $recipientToken,
            'notification' => [
                'title' => config('app.name'),
                'body' => $message,
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $data);

        // Verificar la respuesta y manejarla según tus necesidades.
        if ($response->successful()) {
            // Notificación enviada exitosamente.
            return true;
        } else {
            // Manejar el error, por ejemplo, registrar en el registro de errores.
            return false;
        }
    }
}
