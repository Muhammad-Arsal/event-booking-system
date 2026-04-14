<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService
    ) {}

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'location' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
        ]);

        $filters = [
            'location' => trim((string) ($validated['location'] ?? '')),
            'date' => $validated['date'] ?? null,
        ];

        $events = $this->eventService
            ->getPaginatedEvents(10, $filters)
            ->withQueryString();

        return view('events.index', compact('events'));
    }

    public function show(string $event): View
    {
        $event = $this->eventService->getEventById((int) $event);

        return view('events.show', compact('event'));
    }

    public function create(): View
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $event = $this->eventService->createEvent(
            $request->validated(),
            (int) $request->user()->id
        );

        return redirect()
            ->route('events.show', $event->id)
            ->with('status', 'Event created successfully.');
    }

    public function edit(string $event): View
    {
        $event = $this->eventService->getEventById((int) $event);
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, string $event): RedirectResponse
    {
        $event = $this->eventService->getEventById((int) $event);
        $this->authorize('update', $event);

        $event = $this->eventService->updateEvent($event, $request->validated());

        return redirect()
            ->route('events.show', $event->id)
            ->with('status', 'Event updated successfully.');
    }

    public function destroy(string $event): RedirectResponse
    {
        $event = $this->eventService->getEventById((int) $event);
        $this->authorize('delete', $event);

        $this->eventService->deleteEvent($event);

        return redirect()
            ->route('events.index')
            ->with('status', 'Event deleted successfully.');
    }
}
