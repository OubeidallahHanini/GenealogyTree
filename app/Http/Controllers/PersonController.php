<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PersonController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Applique le middleware 'auth' à toutes les méthodes sauf 'index' et 'show'
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the people.
     */
    public function index()
    {
        $people = Person::with('creator')->get(); // Récupère toutes les personnes avec leur créateur
        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new person.
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created person in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        // Formatage des données
        $first_name = ucfirst(strtolower($request->first_name));
        $middle_names = $request->middle_names ? collect(explode(',', $request->middle_names))
            ->map(fn($name) => ucfirst(strtolower(trim($name))))
            ->implode(', ') : null;
        $last_name = strtoupper($request->last_name);
        $birth_name = $request->birth_name ? strtoupper($request->birth_name) : $last_name;
        $date_of_birth = $request->date_of_birth ? $request->date_of_birth : null;  // Assurez-vous que le format est YYYY-MM-DD dans le formulaire

        // Création de la personne
        $person = new Person([
            'created_by' => Auth::id(),
            'first_name' => $first_name,
            'middle_names' => $middle_names,
            'last_name' => $last_name,
            'birth_name' => $birth_name,
            'date_of_birth' => $date_of_birth
        ]);

        $person->save();

        return redirect()->route('people.index')->with('success', 'Person created successfully.');
    }


    /**
     * Display the specified person.
     */
    public function show(Person $person)
    {
        $person->load('children', 'parents'); // Eager load the children and parents of the person
        return view('people.show', compact('person'));
    }
}
