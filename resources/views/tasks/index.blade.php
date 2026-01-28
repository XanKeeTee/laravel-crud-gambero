<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Tareas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end items-center mb-6 gap-2">

                <div x-data="{ open: false }" class="relative flex items-center justify-end">
                    <div class="flex items-center transition-all duration-500 ease-in-out border"
                        :class="open ? 'w-64 bg-white border-gray-300 shadow-sm rounded-full' :
                            'w-10 bg-transparent border-transparent rounded-full'">
                        <button @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center text-gray-600 hover:text-indigo-600 transition-colors focus:outline-none bg-transparent rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <input x-ref="searchInput" x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" type="text"
                            id="taskSearch" placeholder="Buscar..."
                            class="w-full pr-4 py-2 border-none focus:ring-0 text-sm bg-white text-gray-700 rounded-full"
                            @keyup="searchTasks()" @click.away="if($el.value === '') open = false">
                    </div>
                </div>

                <a href="{{ route('tasks.create') }}"
                    style="background-color: #1f2937; color: white; text-decoration: none;"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase tracking-widest shadow-md hover:bg-gray-700 transition">
                    + {{ __('Crear Tarea') }}
                </a>
            </div>

            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-200"
                style="max-height: 600px; overflow-y: auto; position: relative;">
                <table class="w-full text-sm text-gray-700" id="tasksTable"
                    style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)"
                                style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb; cursor: pointer;"
                                class="px-6 py-4 font-extrabold text-gray-900 group">
                                {{ __('TÍTULO') }} <span
                                    class="text-indigo-400 group-hover:text-indigo-600 transition-colors">⇅</span>
                            </th>
                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900"> {{ __('DESCRIPCIÓN') }} </th>
                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900"> {{ __('ESTADO') }} </th>
                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900"> {{ __('ACCIONES') }} </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white" id="tasksTableBody">
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-gray-50 transition-colors task-row">
                                <td style="text-align: center;" class="px-6 py-4 font-bold text-gray-900 task-title">
                                    {{ $task->title }}</td>
                                <td style="text-align: center;" class="px-6 py-4 text-gray-600">{{ $task->description }}
                                </td>
                                <td style="text-align: center;" class="px-6 py-4">
                                    <div style="display: flex; justify-content: center;">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold border"
                                            style="width: 110px; {{ $task->status === 'Completada' ? 'background-color: #dcfce7; color: #15803d; border-color: #bbf7d0;' : 'background-color: #fef9c3; color: #a16207; border-color: #fef08a;' }}">
                                            {{ $task->status }}
                                        </span>
                                    </div>
                                </td>
                                <td style="text-align: center;" class="px-6 py-4">
                                    <div style="display: flex; justify-content: center; gap: 10px;">
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                            style="background-color: #4f46e5 !important; color: white !important; text-decoration: none;"
                                            class="px-3 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-sm">
                                            {{ __('EDITAR') }}
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="margin: 0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Borrar tarea?')"
                                                style="background-color: #dc2626 !important; color: white !important; border: none; cursor: pointer;"
                                                class="px-3 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-sm">
                                                {{ __('BORRAR') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noResultsRow">
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                    {{ __('No hay tareas registradas.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchTasks() {
            let filter = document.getElementById('taskSearch').value.toLowerCase();
            let rows = document.querySelectorAll('.task-row');
            rows.forEach(row => {
                let title = row.querySelector('.task-title').textContent.toLowerCase();
                row.style.display = title.includes(filter) ? "" : "none";
            });
        }

        let sortOrder = 1;

        function sortTable(columnIndex) {
            const tableBody = document.getElementById('tasksTableBody');
            const rows = Array.from(tableBody.querySelectorAll('.task-row'));
            const sortedRows = rows.sort((a, b) => {
                const textA = a.children[columnIndex].textContent.trim().toLowerCase();
                const textB = b.children[columnIndex].textContent.trim().toLowerCase();
                return textA.localeCompare(textB) * sortOrder;
            });
            sortOrder *= -1;
            tableBody.innerHTML = '';
            sortedRows.forEach(row => tableBody.appendChild(row));
        }
    </script>
</x-app-layout>