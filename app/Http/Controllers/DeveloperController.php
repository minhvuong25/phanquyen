<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use App\Http\Requests\Developers\StoreRequest;
use App\Http\Requests\Developers\UpdateRequest;

class DeveloperController extends Controller
{
    protected $developer;

    public function __construct(Developer $developer)
    {
        $this->developer = $developer;
    }
    
    public function index()
    {
        $developers = $this->developer->all();
        return view('developers.index', compact('developers'));
    }

    public function show($id)
    {
        $developer = $this->developer->findOrFail($id);
        return view('developers.show', compact('developer'));
    }

    public function create()
    {
        return view('developers.create');
    }

    public function store(StoreRequest $request)
    {
        $developer = $request->all();
        $this->developer->create($developer);
        return redirect()->route('developers.index');
    }

    public function edit($id)
    {
        $developer = $this->developer->findOrFail($id);
        return view('developers.edit', compact('developer'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $developer = $this->developer->findOrFail($id);
        $developer->update($data);
        return redirect()->route('developers.index');
    }

    public function destroy($id)
    {
        $developer = $this->developer->findOrFail($id);
        $developer->delete();
        return redirect()->route('developers.index');
    }
}
