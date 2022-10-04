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
                    <x-table.heading sortable multi-column wire:click="sortBy('user_id')" :direction="$sorts['user_id'] ?? null">User</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('nominal_transfer')" :direction="$sorts['nominal_transfer'] ?? null">Nominal Transfer</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('approval_status')" :direction="$sorts['approval_status'] ?? null">Approval Status</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('verification_status')" :direction="$sorts['verification_status'] ?? null">Verification Status</x-table.heading>
                    <x-table.heading>File</x-table.heading>
                    <x-table.heading>Invoice</x-table.heading>
                    <x-table.heading>Kwitansi</x-table.heading>
                    <x-table.heading/>
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
                            <span class="text-cool-gray-900 font-medium">{{ $item->user->name }} </span>
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
                            <a target="_blank" href="{{ Storage::url($item->file) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Lihat</a>
                        </x-table.cell>

                        <x-table.cell>
                            <a target="_blank" wire:click="invoice({{ $item->id }})" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Invoice</a>
                            
                        </x-table.cell>

                        <x-table.cell>
                            @if($item->verification_status == 'Approved')<a target="_blank" wire:click="kwitansi({{ $item->id }})" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none "> Kwitansi </a> @else <a disabled="disabled" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Kwitansi</a>@endif
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
                <x-input.group for="nominal_transfer" label="Nominal Transfer">
                    <x-input.text disabled type="number" value="{{ $editing->nominal_transfer }}" id="nominal_transfer" placeholder="Nominal Transfer" />
                </x-input.group>

                <x-input.group for="tanggal_transfer" label="Tanggal Transfer">
                <x-input.text disabled type="text" value="{{ $editing->tanggal_transfer }}" id="tanggal_transfer" placeholder="Tanggal Transfer" />
                </x-input.group>


                <x-input.group for="File" label="File">
                    <x-table.cell>
                        <a target="_blank" href="{{ Storage::url($editing->file) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Lihat</a>
                    </x-table.cell>
                </x-input.group>

                <x-input.group for="Invoice" label="Invoice">
                    <x-table.cell>
                        <a target="_blank" wire:click="invoice({{ $editing->id }})" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Invoice</a>
                    </x-table.cell>
                </x-input.group>

                <x-input.group for="Kwitansi" label="Kwitansi">
                    <x-table.cell>
                        @if($editing->verification_status == 'Approved')<a target="_blank" wire:click="kwitansi({{ $editing->id }})" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none "> Kwitansi </a> @else <a disabled="disabled" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Kwitansi</a>@endif
                    </x-table.cell>
                </x-input.group>
                
                
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>

                <button wire:click="rejected({{ $editing->id }})" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Reject</button>
                
                <button wire:click="approved({{ $editing->id }})" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Approve</button>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>


