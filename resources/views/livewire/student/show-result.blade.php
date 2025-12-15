<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold mb-2">Шалгалтын үр дүн</h2>
                    <div class="text-xl">
                        Таны оноо: <span class="font-bold text-blue-600">{{ $totalScore }}</span> / {{ $maxScore }}
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xl font-semibold">Дэлгэрэнгүй хариулт:</h3>

                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $attempt->answers->where('question_id', $question->id)->first();
                            $userChoiceId = $userAnswer ? $userAnswer->choice_id : null;
                            $isCorrect = $userAnswer ? $userAnswer->is_correct : false;
                        @endphp

                        <div class="border rounded-lg p-4 {{ $isCorrect ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                            <div class="flex justify-between items-start mb-2">
                                <div class="font-medium">
                                    {{ $index + 1 }}. {{ $question->content }}
                                    <span class="text-sm text-gray-500 ml-2">({{ $question->points }} оноо)</span>
                                </div>
                                <div>
                                    @if($isCorrect)
                                        <span class="px-2 py-1 bg-green-200 text-green-800 text-xs rounded-full">Зөв</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-200 text-red-800 text-xs rounded-full">Буруу</span>
                                    @endif
                                </div>
                            </div>

                            <div class="ml-4 space-y-2 mt-2">
                                @foreach($question->choices as $choice)
                                    <div class="flex items-center space-x-2">
                                        @if($choice->id == $userChoiceId)
                                            <!-- User selected this -->
                                            @if($choice->is_correct)
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @endif
                                        @elseif($choice->is_correct && !$isCorrect)
                                            <!-- Correct answer not selected by user -->
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @else
                                            <div class="w-5 h-5"></div> 
                                        @endif

                                        <span class="{{ $choice->id == $userChoiceId ? 'font-bold' : '' }} {{ $choice->is_correct ? 'text-green-700' : '' }}">
                                            {{ $choice->content }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('subjects') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Жагсаалт руу буцах
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
