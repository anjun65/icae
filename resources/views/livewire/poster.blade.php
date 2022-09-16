<div>
    

    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Poster</h1>

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
                    <x-table.heading sortable multi-column wire:click="sortBy('link_poster')" :direction="$sorts['file_poster'] ?? null">File Poster</x-table.heading>
                    
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
                                    <x-icon.cash class="text-cool-gray-400"/> {{ $item->paper_code }}
                                </p>
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->paper_title }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->presenter_name }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->vita_presenter }} </span>
                        </x-table.cell>
                
                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->link_video }} </span>
                        </x-table.cell>


                        <x-table.cell>
                            <img src="{{ Storage::url($item->file_poster) }}" class="w-full" alt="">
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
                <x-input.group for="paper_code" label="Edas item Code" :error="$errors->first('editing.paper_code')">
                    <x-input.text wire:model="editing.paper_code" id="paper_code" placeholder="Edas item Code" />
                </x-input.group>

                <x-input.group for="paper_title" label="Paper Title" :error="$errors->first('editing.paper_title')">
                    <x-input.text wire:model="editing.paper_title" id="paper_title" placeholder="Paper Title" />
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

                <x-input.group label="Upload Poster" for="file_poster" :error="$errors->first('upload')">
                    @if ($upload)
                        <div class="mb-5">
                            {{ $upload->getClientOriginalName()}}
                        </div>
                    @endif
                    <x-input.file-upload wire:model="upload" accept="image/png, image/jpeg" id="upload">
                        
                    </x-input.file-upload>
                </x-input.group>

                
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
