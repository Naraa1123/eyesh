<div class="max-w-3xl mx-auto py-10">

    {{-- Толгой хэсэг --}}
    <div
        class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6 sticky top-0 z-50"
        x-data="{
            timeLeft: {{ $attemptTimeLeft ?? 0 }},
            timerInterval: null,
            init() {
                if (this.timeLeft > 0) {
                    this.timerInterval = setInterval(() => {
                        this.timeLeft--;
                        if (this.timeLeft <= 0) {
                            clearInterval(this.timerInterval);
                            alert('Шалгалтын цаг дууслаа! Таны хариултыг илгээж байна.');
                            $wire.submit();
                        }
                    }, 1000);
                }
            },
            get formattedTime() {
                if (this.timeLeft <= 0) return '00:00:00';
                
                let hours = Math.floor(this.timeLeft / 3600);
                let minutes = Math.floor((this.timeLeft % 3600) / 60);
                let seconds = Math.floor(this.timeLeft % 60);

                return [hours, minutes, seconds]
                    .map(v => v < 10 ? '0' + v : v)
                    .join(':');
            }
        }"
    >
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $variant->exam->title }}</h1>
                <p class="text-gray-600 mt-1">{{ $variant->description }}</p>
            </div>
            
            @if($attemptTimeLeft !== null)
                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-1">Үлдсэн хугацаа</div>
                    <div class="text-3xl font-mono font-bold" :class="timeLeft < 300 ? 'text-red-600' : 'text-indigo-600'">
                        <span x-text="formattedTime"></span>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-4 flex items-center justify-between text-sm font-medium text-gray-500 border-t pt-4">
            <span>Хувилбар: {{ $variant->label }}</span>
            <span>Нийт асуулт: {{ $questions->count() }}</span>
        </div>
    </div>

    {{-- Асуултуудын жагсаалт --}}
    <form wire:submit="submit">
        <div class="space-y-6">
            @foreach($questions as $index => $question)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">

                    {{-- Асуултын текст --}}
                    <div class="flex gap-3 mb-4">
                        <span class="flex-none bg-indigo-100 text-indigo-700 font-bold w-8 h-8 flex items-center justify-center rounded-full text-sm">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $question->text }}
                            </h3>
                            <span class="text-xs text-gray-400 font-medium">
                                ({{ $question->points }} оноо)
                            </span>
                        </div>
                    </div>

                    {{-- Хариултын сонголтууд --}}
                    <div class="space-y-2 ml-11">
                        @foreach($question->choices as $choice)
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ isset($selectedAnswers[$question->id]) && $selectedAnswers[$question->id] == $choice->id ? 'border-indigo-500 bg-indigo-50 ring-1 ring-indigo-500' : 'border-gray-200' }}">
                                <input
                                    type="radio"
                                    wire:model="selectedAnswers.{{ $question->id }}"
                                    value="{{ $choice->id }}"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                >
                                <span class="ml-3 text-gray-700 text-sm">
                                    {{ $choice->text }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Дуусгах товч --}}
        <div class="mt-8 flex justify-end">
            <button
                type="submit"
                onclick="confirm('Та шалгалтыг дуусгахдаа итгэлтэй байна уу?') || event.stopImmediatePropagation()"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:scale-105"
            >
                Шалгалтыг дуусгах
            </button>
        </div>
    </form>
</div>
