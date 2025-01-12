<?php

namespace App\Http\Controllers;

use App\Models\Proposition;
use Illuminate\Http\Request;

class PropositionController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'person_id' => 'required|exists:people,id',
            'description' => 'required|string|max:255',
            'data' => 'required|json' // Assurez-vous que les données sont bien formatées en JSON
        ]);

        $proposition = new Proposition([
            'person_id' => $request->person_id,
            'proposed_by' => auth()->id(),
            'description' => $request->description,
            'data' => $request->data,
            'approvals' => 0,
            'rejections' => 0,
            'is_approved' => false
        ]);

        $proposition->save();

        return redirect()->back()->with('success', 'Proposition submitted successfully.');
    }

    public function approve($id)
    {
        $proposition = Proposition::findOrFail($id);

        $proposition->increment('approvals');

        if ($proposition->approvals >= 3) {
            $proposition->is_approved = true;
            $proposition->save();

            // Appliquer les modifications proposées ici, si nécessaire
            // Par exemple, créer ou modifier la fiche personne ou relation

            return redirect()->back()->with('success', 'Proposition approved and changes applied.');
        }

        return redirect()->back()->with('success', 'Proposition approved. Waiting for more approvals.');
    }

    public function reject($id)
    {
        $proposition = Proposition::findOrFail($id);

        $proposition->increment('rejections');

        if ($proposition->rejections >= 3) {
            $proposition->delete(); // Supprimer la proposition après trois rejets

            return redirect()->back()->with('error', 'Proposition rejected and removed.');
        }

        return redirect()->back()->with('success', 'Proposition rejected. Waiting for more reviews.');
    }

}
