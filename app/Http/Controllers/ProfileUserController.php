<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ambil resource cost dan hitung user terlibat di berapa work package
        $user = auth()->user();
        $resourceCost = $user->roles->get(1)->resource_cost ?? 0;
        $workPackagesCount = $user->work()
            ->with('volume')
            ->get()
            ->map(function($work) {
                return $work->volume->volume_id ?? null;
            })
            ->filter()
            ->unique()
            ->count();
        return view('profile_user', compact('resourceCost', 'workPackagesCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
