<?php

namespace App\Http\Controllers;

use App\Models\Proposition;
use App\Models\PropositionResponse;
use Illuminate\Http\Request;

class PropositionResponseController extends Controller
{
    public function respondToProposition(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|boolean'
        ]);

        PropositionResponse::create([
            'proposition_id' => $id,
            'user_id' => auth()->id(),
            'response' => $request->response
        ]);

        // Vérifier si la proposition est définitivement validée ou invalidée
        $this->checkPropositionStatus($id);

        return back()->with('success', 'Your response has been recorded.');
    }

    protected function checkPropositionStatus($propositionId)
    {
        $proposition = Proposition::with('responses')->findOrFail($propositionId);
        $approvals = $proposition->responses()->where('response', true)->count();
        $rejections = $proposition->responses()->where('response', false)->count();

        if ($approvals >= 3) {
            $proposition->is_approved = true;
            $proposition->save();
            // Trigger any further actions needed upon approval
        } elseif ($rejections >= 3) {
            $proposition->delete(); // or mark as rejected based on your application logic
        }
    }

}
