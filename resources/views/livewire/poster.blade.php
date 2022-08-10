<div>
    <h1 class="text-2xl font-semibold text-gray-900">Poster</h1></h1>

    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filters.item_code" placeholder="Search Paper Code..." />

                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Sembunyikan @endif Pencarian Spesifik...</x-button.link>
            </div>

            <div class="space-x-2 flex items-center">
                <x-input.group borderless paddingless for="perPage" label="Halaman">
                    <x-input.select wire:model="perPage" id="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </x-input.select>
                </x-input.group>

                <x-dropdown label="Aksi">
                    <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                        <x-icon.trash class="text-cool-gray-400"/> <span>Hapus</span>
                    </x-dropdown.item>
                </x-dropdown>

                <x-button.primary wire:click="create"><x-icon.plus/> Baru</x-button.primary>
            </div>
        </div>

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
            <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
                <div class="w-1/2 pr-2 space-y-4">

                    <x-input.group inline for="filter-item_title" label="item Title">
                        <x-input.text wire:model.lazy="filters.item_title" id="filter-item_title" />
                    </x-input.group>

                    
                    <x-input.group inline for="filter-vita_presenter" label="Vita Presenter">
                        <x-input.text wire:model.lazy="filters.vita_presenter" id="filter-vita_presenter" />
                    </x-input.group>

                </div>

                <div class="w-1/2 pl-2 space-y-4">

                     <x-input.group inline for="filter-presenter_name" label="Presenter Name">
                        <x-input.text wire:model.lazy="filters.presenter_name" id="filter-presenter_name" />
                    </x-input.group>

                    <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                </div>
            </div>
            @endif
        </div>

        <!-- Transactions Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-8">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('item_code')" :direction="$sorts['item_code'] ?? null">Edas item Code</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('item_title')" :direction="$sorts['item_title'] ?? null">item Title</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('presenter_name')" :direction="$sorts['presenter_name'] ?? null">Presenter Name</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('vita_presenter')" :direction="$sorts['vita_presenter'] ?? null">Vita for the presenter</x-table.heading> 
                    <x-table.heading sortable multi-column wire:click="sortBy('link_video')" :direction="$sorts['link_video'] ?? null">Link Video</x-table.heading>
                    
                    <x-table.heading />
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                    <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                        <x-table.cell colspan="8">
                            @unless ($selectAll)
                            <div>
                                <span>You have selected <strong>{{ $items->count() }}</strong> data, Do you want to select all data <strong>{{ $items->total() }}</strong>?</span>
                                <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                            </div>
                            @else
                            <span>You have selected <strong>{{ $items->total() }}</strong> data.</span>
                            @endif
                        </x-table.cell>
                    </x-table.row>
                    @endif

                    @forelse ($items as $item)
                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $item->id }}">
                        <x-table.cell class="pr-0">
                            <x-input.checkbox wire:model="selected" value="{{ $item->id }}" />
                        </x-table.cell>
                        <x-table.cell>
                            <span href="#" class="truncate text-sm leading-5">
                                

                                <p class="inline-flex text-cool-gray-600 truncate">
                                    <x-icon.cash class="text-cool-gray-400"/> {{ $item->item_code }}
                                </p>
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->item_title }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->presenter_name }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->vita_presenter }} </span>
                        </x-table.cell>
                
                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->file_poster }} </span>
                        </x-table.cell>


                        <x-table.cell>
                            <span class="inline-flex items-center py-0.5 rounded-full text-xs font-medium leading-4">
                                {{ $item->link_video }}
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <x-button.link wire:click="edit({{ $item->id }})">Edit</x-button.link>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                    <x-table.row>
                        <x-table.cell colspan="8">
                            <div class="flex justify-center items-center space-x-2">
                                <x-icon.inbox class="h-8 w-8 text-cool-gray-400" />
                                <span class="font-base py-8 text-cool-gray-400 text-xl">No item was Found...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $items->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Transactions Modal -->
    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Delete item</x-slot>

            <x-slot name="content">
                <div class="py-8 text-cool-gray-700">Are you sure? Deleted data cannot be recovered.</div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showDeleteModal', false)">Batal</x-button.secondary>

                <x-button.primary type="submit">Hapus</x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>

    <!-- Save Transaction Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Add Poster</x-slot>

            <x-slot name="content">
                <x-input.group for="item_code" label="Edas item Code" :error="$errors->first('editing.item_code')">
                    <x-input.text wire:model="editing.item_code" id="item_code" placeholder="Edas item Code" />
                </x-input.group>

                <x-input.group for="item_title" label="Paper Title" :error="$errors->first('editing.item_title')">
                    <x-input.text wire:model="editing.item_title" id="item_title" placeholder="Paper Title" />
                </x-input.group>


                <x-input.group for="presenter_name" label="Presenter Name" :error="$errors->first('editing.presenter_name')">
                    <x-input.text wire:model="editing.presenter_name" id="presenter_name" placeholder="Presenter Name" />
                </x-input.group>

                <x-input.group for="vita_presenter" label="Vita Presenter" :error="$errors->first('editing.vita_presenter')">
                    <x-input.text wire:model="editing.vita_presenter" id="vita_presenter" placeholder="Vita Presenter" />
                </x-input.group>

                <x-input.group for="link_video" label="Link Video" :error="$errors->first('editing.link_video')">
                    <x-input.text wire:model="editing.link_video" id="link_video" placeholder="Link video" />
                </x-input.group>

                <x-input.group for="file_poster" label="File Poster" :error="$errors->first('editing.file_poster')">
                    <div class="flex flex-col flex-grow mb-3">
                        <div x-data="{ files: null }" id="FileUpload" class="block w-full py-2 px-3 relative bg-white appearance-none border-2 border-gray-300 border-solid rounded-md hover:shadow-outline-gray">
                            <input type="file" multiple
                                class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                                x-on:change="files = $event.target.files; console.log($event.target.files);"
                                x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                            >
                            <template x-if="files !== null">
                                <div class="flex flex-col space-y-1">
                                    <template x-for="(_,index) in Array.from({ length: files.length })">
                                        <div class="flex flex-row items-center space-x-2">
                                            <template x-if="files[index].type.includes('audio/')"><i class="far fa-file-audio fa-fw"></i></template>
                                            <template x-if="files[index].type.includes('application/')"><i class="far fa-file-alt fa-fw"></i></template>
                                            <template x-if="files[index].type.includes('image/')"><i class="far fa-file-image fa-fw"></i></template>
                                            <template x-if="files[index].type.includes('video/')"><i class="far fa-file-video fa-fw"></i></template>
                                            <span class="font-medium text-gray-900" x-text="files[index].name">Uploading</span>
                                            <span class="text-xs self-end text-gray-500" x-text="filesize(files[index].size)">...</span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="files === null">
                                <div class="flex flex-col space-y-2 items-center justify-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                                    <p class="text-gray-700">Drag your files here or click in this area.</p>
                                    <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-indigo-600">Select a file</a>
                                </div>
                            </template>
                        </div>
                    </div>
                </x-input.group>
                
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
