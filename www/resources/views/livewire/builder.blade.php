<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 px-6 p-4 sticky top-0 z-50">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Survey Draft №') }} {{ $survey->id }}
            </h2>
            <div class="flex items-center">
                <div class="mr-4 upd-progress hidden" wire:loading.flex>
                    <span class="upd-progress__dot upd-progress__dot-1">.</span>
                    <span class="upd-progress__dot upd-progress__dot-2">.</span>
                    <span class="upd-progress__dot upd-progress__dot-3">.</span>
                </div>
                <span class="text-sm text-gray-500">
                    updated <span time-counter-update="{{ strtotime($survey->updated_at) }}">just now</span>
                </span>
            </div>
            <style>
                .upd-progress__dot {
                    opacity: 1;
                }
                .upd-progress__dot-1 {
                    animation: blink-1 0.6s ease infinite;
                }
                .upd-progress__dot-2 {
                    animation: blink-2 0.6s ease infinite;
                }
                .upd-progress__dot-3 {
                    animation: blink-3 0.6s ease infinite;
                }
                @keyframes blink-1 {
                    0% {
                        opacity: 1;
                    }
                    30% {
                        opacity: 0;
                    }
                    40% {
                        opacity: 1;
                    }
                }
                @keyframes blink-2 {
                    0% {
                        opacity: 1;
                    }
                    60% {
                        opacity: 0;
                    }
                    70% {
                        opacity: 1;
                    }
                }
                @keyframes blink-3 {
                    0% {
                        opacity: 1;
                    }
                    80% {
                        opacity: 0;
                    }
                    90% {
                        opacity: 1;
                    }
                }
            </style>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6">
        <h2 class="text-lg">Survey options</h2>
        <form class="pt-4 grid grid-cols-2 gap-4" wire:submit.prevent="submit">
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" wire:model="survey.title" type="text" required />
                @error('survey.title') <div class="text-sm text-red-400">{{ $message }}</div> @enderror
            </div>
            <div>
                <x-input-label for="slug" :value="__('Slug')" />
                <div class="flex w-full">
                    <label for="slug" class="border flex items-center mt-1 pl-2 rounded-md border-gray-300 rounded-tr-none rounded-br-none border-r-0">
                        {{ config('app.url') }}/
                    </label>
                    <div class="grow">
                        <x-text-input id="slug" class="block mt-1 w-full rounded-tl-none rounded-bl-none border-l-0 pl-0" wire:model="survey.slug" type="text" required />
                    </div>
                </div>
                @error('survey.slug') <div class="text-sm text-red-400">{{ $message }}</div> @enderror
            </div>
        </form>
    </div>
    <div class="">
        <div class="">
            <div class="flex">
                <div class="bg-white shadow-sm sm:rounded-lg mr-3 p-6 shrink-0">
                    <div class="sticky top-20">
                        <h3>Builder blocks</h3>
                        <div class="mt-2 builder-blocks-buttons">
                            <ul>
                            @foreach (\App\Models\Block::TYPES as $key => $type)
                                @if ($type)
                                    <li class="">
                                        <button draggable="true" class="item rounded-md px-3 py-1 bg-indigo-50 mt-1 hover:bg-indigo-100 flex items-center w-full" data-block-id="{{ $key }}" wire:click="createBlock({{ $key }})">
                                            <div class="">
                                                
                                            </div>
                                            <div class="">
                                                {{ $type['name'] }}
                                            </div>
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="grow">
                    <div class="survey-page-selector flex p-6 justify-between bg-white overflow-hidden shadow-sm sm:rounded-lg items-center">
                        @if (count($survey->pages) > 1)
                            <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model="currentPagePosition">
                                @foreach ($survey->pages as $key => $page)
                                    <option value="{{ $key + 1 }}" {{ ($key + 1 === $currentPagePosition ? 'selected' : '' ) }}>Page {{ $key + 1 }}</option>
                                @endforeach
                            </select>
                        @else
                        <div class="text-sm text-gray-500">This survey contains only one page</div>
                        @endif
                        <div class="">
                            <button class="border p-2 px-4 rounded-md focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:click="createPage">
                                Add new page
                            </button>
                            <button class="border p-2 px-4 rounded-md focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:click="duplicateCurrentPage">
                                Copy current page
                            </button>
                            @if (count($survey->pages) > 1)
                                <button class="border p-2 px-4 rounded-md focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" wire:click="removeCurrentPage">
                                    Remove current page
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="survey-pages mt-3 p-6 justify-between bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <livewire:builder-page :page="$survey->pages[$currentPagePosition - 1]" :showPageTitle="count($survey->pages) > 1 ? true : false" :wire:key="$survey->pages[$currentPagePosition - 1]->id"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
