<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->attemptedRoleEscalation()) {
            Log::warning('Mass assignment attempt blocked', [
                'action' => 'mass_assignment_blocked',
                'user_id' => $user->id,
                'email' => $user->email,
                'submitted_fields' => $request->submittedRoleFields(),
                'ip' => $request->ip(),
            ]);
        }

        $user->update($request->profileAttributes());

        return redirect()
            ->route('profile.edit')
            ->with('message', 'Profilo aggiornato con successo');
    }
}
