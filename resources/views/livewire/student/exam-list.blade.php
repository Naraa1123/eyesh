<div class="max-w-4xl mx-auto py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            {{ $subject->name }} - Шалгалтууд
        </h1>
        <a href="{{ route('subjects') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <span>&larr;</span> Буцах
        </a>
    </div>

    <div class="grid gap-6">
        @forelse($exams as $exam)
            {{-- x-data ашиглаж тухайн card доторх хувьсагчийг зарлана --}}
            <div x-data="{ selectedVariant: '' }" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                    {{-- Мэдээллийн хэсэг --}}
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ $exam->title }}</h2>
                        <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $exam->description }}</p>

                        <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $exam->duration_minutes }} минут
                            </span>
                            <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-medium text-gray-600 border border-gray-200">
                                {{ $exam->variants->count() }} хувилбартай
                            </span>
                        </div>
                    </div>

                    {{-- Үйлдэл хийх хэсэг --}}
                    <div class="flex flex-col gap-3 w-full md:w-auto min-w-[200px]">

                        @if($exam->variants->isNotEmpty())
                            {{-- Хувилбар сонгох Dropdown --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1 ml-1">Хувилбар сонгох:</label>
                                <select x-model="selectedVariant" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                                    <option value="">-- Сонгоно уу --</option>
                                    @foreach($exam->variants as $variant)
                                        <option value="{{ $variant->id }}">
                                            Хувилбар {{ $variant->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Эхлүүлэх товч --}}
                            {{-- Dropdown сонгоогүй үед идэвхгүй (disabled) байна --}}
                            <button
                                :disabled="!selectedVariant"
                                :class="!selectedVariant ? 'opacity-50 cursor-not-allowed bg-gray-400' : 'bg-indigo-600 hover:bg-indigo-700'"
                                @click="window.location.href = '/exam/take/' + selectedVariant"
                                class="w-full text-white px-4 py-2.5 rounded-lg font-medium transition duration-150 flex justify-center items-center"
                            >
                                Шалгалт эхлүүлэх
                            </button>
                        @else
                            <div class="text-red-500 text-sm font-medium bg-red-50 p-2 rounded text-center border border-red-100">
                                Хувилбар ороогүй байна
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Шалгалт байхгүй байна</h3>
                <p class="mt-1 text-gray-500">Энэ хичээл дээр одоогоор шалгалт нэмэгдээгүй байна.</p>
            </div>
        @endforelse
    </div>
</div>
