<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Tarea') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" style="min-height: 100vh;">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('tasks.store') }}" method="POST" id="create-task-form"
                        onsubmit="return handleFormSubmit(this);">
                        @csrf
                        <input type="hidden" name="status" value="Pendiente">

                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase">Título</label>
                            <input
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900"
                                id="title" type="text" name="title" placeholder="Ej: Comprar Patatas" required>
                            @error('title') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2 uppercase">Descripción</label>
                            <textarea
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-900"
                                id="description" name="description" rows="3" placeholder="¿Qué hay que hacer?"></textarea>
                            @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <button type="submit" id="submit-btn"
                                style="background-color: #4f46e5 !important; color: white !important;"
                                class="px-5 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-md transition">
                                GUARDAR
                            </button>

                            <a href="{{ route('tasks.index') }}"
                                class="font-bold text-sm text-indigo-600 hover:text-indigo-800">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleFormSubmit(form) {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.innerText = 'ENVIANDO...';
            return true; 
        }
    </script>
</x-app-layout>
