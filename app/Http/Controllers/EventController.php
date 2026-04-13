<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index');
    }

    public function show(string $event)
    {
        return view('events.show', compact('event'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        // Placeholder: handle event creation logic here
        return redirect()->route('events.index')->with('status', 'Event created successfully (placeholder).');
    }

    public function edit(string $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, string $event)
    {
        // Placeholder: handle event update logic here
        return redirect()->route('events.show', $event)->with('status', 'Event updated successfully (placeholder).');
    }

    public function destroy(string $event)
    {
        // Placeholder: handle event deletion logic here
        return redirect()->route('events.index')->with('status', 'Event deleted successfully (placeholder).');
    }
}
