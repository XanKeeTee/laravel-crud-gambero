<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Tareas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-6">
                <a href="{{ route('tasks.create') }}"
                    style="background-color: #1f2937; color: white; text-decoration: none;"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase tracking-widest shadow-md">
                    + Crear Tarea
                </a>
            </div>

            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-200"
                style="max-height: 600px; overflow-y: auto; position: relative;">

                <table class="w-full text-sm text-gray-700" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900">TÍTULO</th>

                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900">DESCRIPCIÓN</th>

                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900">ESTADO</th>

                            <th style="position: sticky; top: 0; z-index: 10; background-color: #ffffff; text-align: center; border-bottom: 1px solid #e5e7eb;"
                                class="px-6 py-4 font-extrabold text-gray-900">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td style="text-align: center;" class="px-6 py-4 font-bold text-gray-900">
                                    {{ $task->title }}
                                </td>

                                <td style="text-align: center;" class="px-6 py-4 text-gray-600">
                                    {{ $task->description }}
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
                                            EDITAR
                                        </a>

                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                            style="margin: 0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Borrar tarea?')"
                                                style="background-color: #dc2626 !important; color: white !important; border: none; cursor: pointer;"
                                                class="px-3 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-sm">
                                                BORRAR
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">No hay tareas
                                    registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
