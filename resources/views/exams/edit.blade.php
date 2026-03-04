<x-app-layout>
    <div class="max-w-3xl">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Edit Exam</h1>
            <p class="text-sm text-slate-400 mt-0.5">Update exam details and questions</p>
        </div>

        <form action="{{ route('exams.update', $exam) }}" method="POST" id="exam-form">
            @csrf
            @method('PUT')

            {{-- Exam Details --}}
            <div class="bg-white rounded-2xl p-6 flex flex-col gap-4 mb-4" style="border:1px solid #e2e8f0;">
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide">Exam Details</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Exam Name</label>
                        <input name="name" type="text" value="{{ old('name', $exam->name) }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject</label>
                        <select name="subject_id" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none cursor-pointer bg-slate-50" style="border:1px solid #e2e8f0;">
                            <option value="">Select subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Duration (minutes)</label>
                        <input name="duration" type="number" min="1" value="{{ old('duration', $exam->duration) }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                        @error('duration')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Start Date & Time</label>
                        <input name="start" type="datetime-local" value="{{ old('start', \Carbon\Carbon::parse($exam->start)->format('Y-m-d\TH:i')) }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                        @error('start')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">End Date & Time</label>
                        <input name="end" type="datetime-local" value="{{ old('end', \Carbon\Carbon::parse($exam->end)->format('Y-m-d\TH:i')) }}" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                        @error('end')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                        <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50 resize-none" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">{{ old('description', $exam->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none cursor-pointer bg-slate-50" style="border:1px solid #e2e8f0;">
                            <option value="1" {{ old('status', $exam->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $exam->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Assign to Classes <span class="text-slate-400 font-normal">(optional)</span></label>
                        <div class="flex flex-col gap-1 overflow-y-auto rounded-xl p-2" style="max-height:120px;border:1px solid #e2e8f0;background:#fafafa;">
                            @foreach ($classes as $class)
                                <label class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="class_ids[]" value="{{ $class->id }}" class="w-4 h-4 rounded accent-blue-600" {{ in_array($class->id, old('class_ids', $exam->classes->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-700">{{ $class->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Questions Builder --}}
            <div class="bg-white rounded-2xl p-6 mb-4" style="border:1px solid #e2e8f0;">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide">Questions</h2>
                    <div class="flex gap-2">
                        <button type="button" onclick="addQuestion('mcq')" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold hover:opacity-90" style="background:#eff6ff;color:#2563eb;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add MCQ
                        </button>
                        <button type="button" onclick="addQuestion('open_text')" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold hover:opacity-90" style="background:#f0fdf4;color:#16a34a;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add Open Text
                        </button>
                    </div>
                </div>

                <div id="questions-container" class="flex flex-col gap-4">
                    {{-- Pre-fill existing questions --}}
                    @foreach ($exam->questions as $q)
                        @php $qi = $loop->index; @endphp
                        <div id="question-{{ $qi }}" class="rounded-2xl p-5 flex flex-col gap-3" style="border:1px solid #e2e8f0;">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="{{ $q->type === 'mcq' ? 'background:#eff6ff;color:#2563eb;' : 'background:#f0fdf4;color:#16a34a;' }}">
                                    {{ $q->type === 'mcq' ? 'Multiple Choice' : 'Open Text' }}
                                </span>
                                <button type="button" onclick="removeQuestion({{ $qi }})" class="text-xs text-red-400 hover:text-red-600 font-semibold">Remove</button>
                            </div>

                            <input type="hidden" name="questions[{{ $qi }}][type]" value="{{ $q->type }}">

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Question</label>
                                <textarea name="questions[{{ $qi }}][question]" rows="2" class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50 resize-none" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">{{ $q->question }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Marks</label>
                                <input type="number" name="questions[{{ $qi }}][marks]" min="1" value="{{ $q->marks }}" class="w-32 px-3.5 py-2 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                            </div>

                            @if ($q->type === 'mcq')
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="text-xs font-semibold text-slate-600">Answer Options</label>
                                        <button type="button" onclick="addOption({{ $qi }})" class="text-xs font-semibold text-blue-600 hover:underline">+ Add Option</button>
                                    </div>
                                    <div id="options-{{ $qi }}" class="flex flex-col gap-2">
                                        @foreach ($q->options as $opt)
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="questions[{{ $qi }}][correct_option]" value="{{ $loop->index }}" class="accent-blue-600 flex-shrink-0" {{ $opt->is_correct ? 'checked' : '' }}>
                                                <input type="text" name="questions[{{ $qi }}][options][{{ $loop->index }}][option]" value="{{ $opt->option }}" class="flex-1 px-3 py-2 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50" style="border-width:1px;" onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'" onblur="this.style.borderColor='';this.style.boxShadow='none'">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('exams.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 active:scale-95" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <script>
        let questionIndex = {{ $exam->questions->count() }};

        function addQuestion(type) {
            document.getElementById('empty-msg')?.remove();
            const container = document.getElementById('questions-container');
            const idx = questionIndex++;
            const label = type === 'mcq' ? 'Multiple Choice' : 'Open Text';
            const [bg, tc] = type === 'mcq' ? ['#eff6ff', '#2563eb'] : ['#f0fdf4', '#16a34a'];

            const div = document.createElement('div');
            div.id = `question-${idx}`;
            div.className = 'rounded-2xl p-5 flex flex-col gap-3';
            div.style = 'border:1px solid #e2e8f0;';
            div.innerHTML = `
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:${bg};color:${tc};">${label}</span>
            <button type="button" onclick="removeQuestion(${idx})" class="text-xs text-red-400 hover:text-red-600 font-semibold">Remove</button>
        </div>
        <input type="hidden" name="questions[${idx}][type]" value="${type}">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Question</label>
            <textarea name="questions[${idx}][question]" rows="2" placeholder="Enter your question here..."
                class="w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50 resize-none"
                style="border-width:1px;"
                onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
                onblur="this.style.borderColor='';this.style.boxShadow='none'"></textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Marks</label>
            <input type="number" name="questions[${idx}][marks]" min="1" placeholder="e.g. 5"
                class="w-32 px-3.5 py-2 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50"
                style="border-width:1px;"
                onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
                onblur="this.style.borderColor='';this.style.boxShadow='none'">
        </div>
        ${type === 'mcq' ? mcqOptions(idx) : ''}
    `;
            container.appendChild(div);
        }

        function mcqOptions(idx) {
            return `
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="text-xs font-semibold text-slate-600">Answer Options</label>
                <button type="button" onclick="addOption(${idx})" class="text-xs font-semibold text-blue-600 hover:underline">+ Add Option</button>
            </div>
            <div id="options-${idx}" class="flex flex-col gap-2">
                ${optionRow(idx, 0)}
                ${optionRow(idx, 1)}
            </div>
        </div>
    `;
        }

        function optionRow(qIdx, oIdx) {
            return `
        <div class="flex items-center gap-2">
            <input type="radio" name="questions[${qIdx}][correct_option]" value="${oIdx}" class="accent-blue-600 flex-shrink-0">
            <input type="text" name="questions[${qIdx}][options][${oIdx}][option]" placeholder="Option ${oIdx + 1}"
                class="flex-1 px-3 py-2 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50"
                style="border-width:1px;"
                onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
                onblur="this.style.borderColor='';this.style.boxShadow='none'">
        </div>
    `;
        }

        function addOption(qIdx) {
            const container = document.getElementById(`options-${qIdx}`);
            const count = container.children.length;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';
            div.innerHTML = `
        <input type="radio" name="questions[${qIdx}][correct_option]" value="${count}" class="accent-blue-600 flex-shrink-0">
        <input type="text" name="questions[${qIdx}][options][${count}][option]" placeholder="Option ${count + 1}"
            class="flex-1 px-3 py-2 rounded-xl text-sm text-slate-700 outline-none border-slate-200 bg-slate-50"
            style="border-width:1px;"
            onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)'"
            onblur="this.style.borderColor='';this.style.boxShadow='none'">
    `;
            container.appendChild(div);
        }

        function removeQuestion(idx) {
            document.getElementById(`question-${idx}`)?.remove();
        }
    </script>
</x-app-layout>
