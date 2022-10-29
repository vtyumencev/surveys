<div>
    <div class="bg-white border-b border-gray-200 p-4 mb-4 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-4 py-6 max-w-lg m-auto">
            <h2 class="text-lg">Create a new survey</h2>
            <form class="pt-4" wire:submit.prevent="submit">
                <div class="mb-2">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" wire:model="title" type="text" required />
                    @error('title') <div class="text-sm text-red-400">{{ $message }}</div> @enderror
                </div>
                <div class="flex justify-end">
                    <x-primary-button>Next</x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <div class="bg-white border-b border-gray-200 p-4 mt-4 overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="text-lg pl-4">My Drafts</h2>
        <ul class="mt-2" wire:ignore>
            <li class="grid grid-cols-6 px-4 py-2 font-semibold">
                <div class="span col-span-3">Title</div>
                <div class="span">Created</div>
                <div class="span">Updated</div>
            </li>
            @forelse ($drafts as $draft)
                <li class="hover:bg-indigo-50 px-4 py-2" data-draft-id="{{ $draft->id }}">
                    <span class="draft-deleted-placeholder-js hidden">
                        Draft has been deleted
                        <button class="text-indigo-500 ml-4" wire:click="restoreDraft({{ $draft->id }})">
                            Restore
                        </button>
                    </span>
                    <span class="draft-line-js grid grid-cols-6">
                        <span class="col-span-3">
                            <a class="" href="{{ route('surveys.create') . '?draft_id=' . $draft->uuid }}">
                                @if ($draft->title)
                                    {{ $draft->title }}
                                @else
                                    <span class="opacity-50 italic">
                                        Title is not set
                                    </span>
                                @endif
                            </a>
                        </span>
                        <span title="{{ $draft->created_at }}" time-counter-update="{{ strtotime($draft->created_at) }}">
                            {{ $draft->created_at }}
                        </span>
                        <span title="{{ $draft->updated_at }}" time-counter-update="{{ strtotime($draft->updated_at) }}">
                            {{ $draft->updated_at }}
                        </span>
                        <span class="flex justify-end">
                            <a href="{{ route('surveys.create') . '?draft_id=' . $draft->uuid }}" class="text-indigo-500 mr-4">
                                Edit
                            </a>
                            <button class="text-rose-500" wire:click="deleteDraft({{ $draft->id }})">
                                Delete
                            </button>
                        </span>
                    </span>
                </li>
            @empty
                <li>You don't have any drafts</li>
            @endforelse
        </ul>
    </div>
</div>
