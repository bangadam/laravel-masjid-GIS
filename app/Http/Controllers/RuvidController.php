<?php

namespace App\Http\Controllers;

use App\Models\Ruvid;
use Illuminate\Http\Request;

class RuvidController extends Controller
{
    /**
     * Display a listing of the ruvid.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $ruvidQuery = Ruvid::query();
        $ruvidQuery->where('name', 'like', '%' . $request->get('q') . '%');
        $ruvidQuery->orderBy('created_at');
        $ruvids = $ruvidQuery->paginate(25);
        return view('ruvids.index', compact('ruvids'));
    }

    /**
     * Show the form for creating a new ruvid.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Ruvid);

        return view('ruvids.create');
    }

    /**
     * Store a newly created ruvid in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Ruvid);

        $newRuvid = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newRuvid['creator_id'] = auth()->id();

        $ruvid = Ruvid::create($newRuvid);

        return redirect()->route('ruvids.show', $ruvid);
    }

    /**
     * Display the specified ruvid.
     *
     * @param  \App\Models\Ruvid  $ruvid
     * @return \Illuminate\View\View
     */
    public function show(Ruvid $ruvid)
    {
        return view('ruvids.show', compact('ruvid'));
    }

    /**
     * Show the form for editing the specified ruvid.
     *
     * @param  \App\Models\Ruvid  $ruvid
     * @return \Illuminate\View\View
     */
    public function edit(Ruvid $ruvid)
    {
        $this->authorize('update', $ruvid);

        return view('ruvids.edit', compact('ruvid'));
    }

    /**
     * Update the specified ruvid in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruvid  $ruvid
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Ruvid $ruvid)
    {
        $this->authorize('update', $ruvid);

        $ruvidData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $ruvid->update($ruvidData);

        return redirect()->route('ruvids.show', $ruvid);
    }

    /**
     * Remove the specified ruvid from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruvid  $ruvid
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Ruvid $ruvid)
    {
        $this->authorize('delete', $ruvid);

        $request->validate(['ruvid_id' => 'required']);

        if ($request->get('ruvid_id') == $ruvid->id && $ruvid->delete()) {
            return redirect()->route('ruvids.index');
        }

        return back();
    }
}
