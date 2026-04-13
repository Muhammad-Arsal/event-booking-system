<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="leading-tight text-3xl font-bold text-gray-900 mb-2">Detailed Event View Placeholder</h3>
                            <p class="text-gray-500 text-sm">Showing dummy details for event ID: {{ $event }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Edit
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-100">
                        <p class="text-gray-600 text-lg leading-relaxed">
                            This screen has been prepped by the development team and is ready for data integration. 
                            When the backend is wired up, we'll populate this entire section with the specific event's description, location, agenda, and booking status.
                        </p>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <form action="{{ route('bookings.store', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                Book This Event
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                    &larr; Back to Events
                </a>
            </div>
            
        </div>
    </div>
</x-app-layout>
