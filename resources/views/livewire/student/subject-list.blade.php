<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Хичээлүүд</h1>
            <p class="text-gray-500 text-sm mt-1">Таньд боломжтой шалгалтуудын жагсаалт</p>
        </div>

        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="text"
                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   placeholder="Хичээл хайх...">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subjects as $subject)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col h-full group">

                <div class="h-24 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                    <svg class="h-10 w-10 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mb-2">
                                {{ $subject->code ?? 'CODE' }}
                            </span>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                {{ $subject->name }}
                            </h3>
                        </div>
                    </div>

                    <p class="mt-2 text-sm text-gray-500 line-clamp-2 flex-1">
                        {{ $subject->description ?? 'Тайлбар байхгүй байна.' }}
                    </p>

                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center">
                            @if($subject->exams_count > 0)
                                <span class="flex h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                <span class="text-xs font-medium text-gray-600">
                                    {{ $subject->exams_count }} шалгалт идэвхтэй
                                </span>
                            @else
                                <span class="flex h-2 w-2 rounded-full bg-gray-300 mr-2"></span>
                                <span class="text-xs font-medium text-gray-500">
                                    Шалгалт байхгүй
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('exams', $subject->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                            Шалгалтууд харах
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Хичээл олдсонгүй</h3>
                <p class="mt-1 text-sm text-gray-500">Одоогоор ямар нэгэн хичээл бүртгэгдээгүй байна.</p>
            </div>
        @endforelse
    </div>
</div>
