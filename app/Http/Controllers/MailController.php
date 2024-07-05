<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShareMailable;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'to' => 'required|email',
            'body' => 'required|string',
        ]);

        // Datos del correo electrónico
        $to = $request->input('to');
        $body = $request->input('body');

        // Enviar el correo electrónico usando el Mailable
        Mail::to($to)->send(new ShareMailable($body));

        return response()->json(['message' => 'Email sent successfully'], 200);
    }
}
