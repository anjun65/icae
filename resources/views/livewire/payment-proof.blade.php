<div>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Payment</h1>

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
                    <x-table.heading sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">ID</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('nominal_transfer')" :direction="$sorts['nominal_transfer'] ?? null">Nominal Transfer</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('approval_status')" :direction="$sorts['approval_status'] ?? null">Approval Status</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('verification_status')" :direction="$sorts['verification_status'] ?? null">Verification Status</x-table.heading>
                    <x-table.heading >File</x-table.heading>
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
                            <a target="_blank" href="{{ Storage::url($item->file) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none ">Lihat</a>
                            
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
                    <x-input.text type="number" wire:model="editing.nominal_transfer" id="nominal_transfer" placeholder="Nominal Transfer" />
                </x-input.group>

                <x-input.group for="tanggal_transfer" label="Tanggal Transfer" :error="$errors->first('editing.tanggal_transfer')">
                    <x-input.text type="date" wire:model="editing.tanggal_transfer" id="tanggal_transfer" placeholder="Tanggal Transfer" />
                </x-input.group>

                <x-input.group label="Upload Bukti Pembayaran" for="file" :error="$errors->first('upload_bayar')">
                    @if ($upload_bayar)
                        <div class="mb-5">
                            {{ $upload_bayar->getClientOriginalName()}}
                        </div>
                    @endif
                    <x-input.file-upload wire:model="upload_bayar" accept="image/png, image/jpeg" id="upload_bayar">
                        
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


