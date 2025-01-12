<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Str;

class InvitationController extends Controller
{

    public function invite(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $token = Str::random(64);

        Invitation::create([
            'person_id' => $request->person_id,
            'email' => $request->email,
            'invited_by' => auth()->id(),
            'token' => $token,
        ]);

        // Envoyer un email avec le lien d'invitation
        Mail::send('emails.invitation', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Invitation to join our Genealogy Site');
        });

        return back()->with('success', 'Invitation sent successfully.');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $invitation->accepted = true;
        $invitation->save();
    }
}
