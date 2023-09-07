<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class FirebaseController extends Controller
{
    public function sendAll(Request $request)
    {
    	$recipients = User::whereNotNull('device_token')
    		->pluck('device_token')->toArray();
    	// dd($recipients);

    	// fcm()
		//     ->to($recipients) // array
		//     ->notification([
		//         'title' => $request->input('title'),
		//         'body' => $request->input('body')
		//     ])
		//     ->send();

		// $notification = 'Notificación enviada a todos los usuarios (Android).';
		// return back()->with(compact('notification'));
        if (count($recipients) === 0) {
            // No hay dispositivos registrados para recibir notificaciones
            $notification = 'No se enviaron notificaciones, no hay dispositivos registrados.';
        } else {
            $message = [
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ];

            $response = $this->sendFCM($recipients, $message);

            if ($response->successful()) {
                $notification = 'Notificación enviada a todos los usuarios (Android).';
            } else {
                $notification = 'Error al enviar la notificación.';
            }
        }

        return back()->with(compact('notification'));
    }
}
