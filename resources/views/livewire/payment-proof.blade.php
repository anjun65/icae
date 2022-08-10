<div>
    <h1 class="text-2xl font-semibold text-gray-900">Payment</h1></h1>

    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filters.item_code" placeholder="Search Payment Code..." />

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

                    <x-input.group inline for="filter-tanggal" label="Tanggal">
                        <x-input.text wire:model.lazy="filters.tanggal" id="filter-tanggal" />
                    </x-input.group>

                    <x-input.group inline for="filter-approval_status" label="Approval Status">
                        <x-input.text wire:model.lazy="filters.approval_status" id="filter-approval_status" />
                    </x-input.group>

                </div>

                <div class="w-1/2 pl-2 space-y-4">

                     <x-input.group inline for="filter-verification_status" label="Verification Status">
                        <x-input.text wire:model.lazy="filters.verification_status" id="filter-verification_status" />
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
                    <x-table.heading sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">ID</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('nominal_transfer')" :direction="$sorts['nominal_transfer'] ?? null">Nominal Transfer</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('approval_status')" :direction="$sorts['approval_status'] ?? null">Approval Status</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('verification_status')" :direction="$sorts['verification_status'] ?? null">Verification Status</x-table.heading>
                    
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
                                    <x-icon.cash class="text-cool-gray-400"/> {{ $item->id }}
                                </p>
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->nominal_transfer }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->approval_status }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->verification_status }} </span>
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
            <x-slot name="title">Add Payment</x-slot>

            <x-slot name="content">
                <x-input.group for="nominal_transfer" label="Nominal Transfer" :error="$errors->first('editing.nominal_transfer')">
                    <x-input.text wire:model="editing.nominal_transfer" id="nominal_transfer" placeholder="Nominal Transfer" />
                </x-input.group>

                <x-input.group for="tanggal" label="Tanggal Transfer" :error="$errors->first('editing.tanggal')">
                    <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input datepicker datepicker-autohide datepicker-format="mm-dd-yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                    </div>
                    
                </x-input.group>

                <x-input.group for="file_poster" label="Upload Bukti" :error="$errors->first('editing.file_poster')">
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


<script src="https://unpkg.com/flowbite@1.5.1/dist/datepicker.js"></script>