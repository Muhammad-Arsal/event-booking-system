<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Events Listing') }}
            </h2>
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create Event
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="prose max-w-none text-gray-600">
                        <p class="text-lg">
                            We've set up this screen structure for the events dashboard. It is fully ready to be integrated with the database to display our active events.
                        </p>
                    </div>
                    
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Placeholder Card -->
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="h-40 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 mb-4 dashed-border cursor-pointer" onclick="window.location='{{ route('events.show', 1) }}'">
                                <span class="text-sm">Event Image Placeholder</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Sample Event Title</h3>
                            <p class="text-sm text-gray-500 mt-1">Expected date and location here</p>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                                <a href="{{ route('events.show', 1) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Details &rarr;</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
