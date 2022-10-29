<div>
    <div class="survey-page">
        @if ($showPageTitle)
            <div class="mb-6 pb-6 border-b border-gray-200">
                <!-- <div class="relative">
                    <input type="text" wire:model="page.title" id="floating_outlined" class="block px-2.5 pb-2 pt-5 w-full text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50 peer" placeholder=" " />
                    <label for="floating_outlined" class="pointer-events-none absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-0.5 scale-75 top-2 z-10 origin-[0] px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top- peer-focus:scale-75 peer-focus:-translate-y-5 left-1">Page Title</label>
                </div> -->
                <label for="page-title" class="text-xs font-bold">Page Title</label>
                <input wire:model="page.title" id="page-title" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" placeholder="Page Title" type="text">
            </div>
        @endif
        <div>
            <div class="flex justify-between text-xs">
                <div class="font-bold mb-3">Page Content Blocks</div>
                <ul class="grid grid-flow-col gap-4">
                    <!-- <li>
                        <button class="text-indigo-500">Collapse all</button>
                    </li>
                    <li>
                        <button class="text-indigo-500">Expand all</button>
                    </li> -->
                </ul>
            </div>
            <div class="survey-blocks pb-5 -mb-5">
                @forelse ($page->blocks as $key => $block)
                    <div class="survey-block shadow-sm hover:shadow-md transition shadow-slate-300 p-4 rounded-md mb-4 relative">
                        <div class="flex justify-between px-1 text-sm mb-0.5">
                            {{ \App\Models\Block::TYPES[$block->type_id]['name'] }}
                            <div class="">
                                <ul class="grid grid-flow-col gap-4">
                                    @if ($key != 0)
                                    <li><button class="text-indigo-500" title="Move this block up"><i class="bi bi-arrow-up"></i></button></li>
                                    @endif
                                    @if ($key != count($page->blocks) - 1)
                                    <li><button class="text-indigo-500" title="Move this block down"><i class="bi bi-arrow-down"></i></button></li>
                                    @endif
                                    <li><button class="text-indigo-500" title="Open settings"><i class="bi bi-sliders2"></i></button></li>
                                    <!-- <li><button class="text-indigo-500" title="Collapse"><i class="bi bi-arrows-collapse"></i></button></li> -->
                                    <li><button class="text-red-500" title="Move this block to trash" wire:click="deleteBlock({{ $block->id }})"><i class="bi bi-trash3"></i></button></li>
                                </ul>
                            </div>
                        </div>
                        @livewire(\App\Models\Block::TYPES[$block->type_id]['component_edit'], ['block' => $block], key($block->id))
                    </div>
                @empty
                    <div class="p-10 flex justify-center bg-gray-50 rounded-lg">
                        This page is empty
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
