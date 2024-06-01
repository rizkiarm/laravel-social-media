<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrationRequest $request)
    {
        $data = $request->validated();

        $user = User::where(['email' => $data["email"]])->first();
        if(!$user){
            $user = User::create($data);
        }
        
        if(!$user->profile){
            $user->profile()->create();
        }

        return redirect()->route('login');
    }
}
