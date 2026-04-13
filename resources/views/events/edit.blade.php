<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-8 border-l-4 border-amber-400 bg-amber-50 p-4 rounded-r-md">
                        <p class="text-amber-700 text-sm font-medium">
                            This edit screen is awaiting real data binding. For now, it represents the interface we will use to update event information.
                        </p>
                        <p class="text-amber-600 text-xs mt-1">Editing Event ID: {{ $event }}</p>
                    </div>

                    <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Event Title</label>
                            <input id="title" type="text" name="title" value="Sample Title Placeholder" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">This is a placeholder description that would normally be populated with the event's existing details from the database.</textarea>
                        </div>

                        <div class="flex items-center justify-between mt-8 pt-4 border-t border-gray-100">
                            <div>
                                <!-- Delete Button visually separated -->
                                <button type="button" onclick="document.getElementById('delete-event-form').submit();" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Delete
                                </button>
                            </div>
                            <div class="flex items-center">
                                <a href="{{ route('events.show', $event) }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">
                                    Cancel
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Update Event
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Hidden Delete Form -->
                    <form id="delete-event-form" action="{{ route('events.destroy', $event) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
