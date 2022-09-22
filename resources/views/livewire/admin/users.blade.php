<div>
    <h1 class="text-2xl font-semibold text-gray-900">Poster</h1></h1>

    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filters.name" placeholder="Search name..." />
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

        <!-- Transactions Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-8">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Name</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('email')" :direction="$sorts['email'] ?? null">Email</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('email_edas')" :direction="$sorts['email_edas'] ?? null">Email Edas</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('edas_id')" :direction="$sorts['edas_id'] ?? null">Edas ID</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('roles')" :direction="$sorts['roles'] ?? null">Roles</x-table.heading>
                    <x-table.heading></x-table.heading>
                    
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
                            <span class="text-cool-gray-900 font-medium">{{ $item->name }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->email }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span href="#" class="truncate text-sm leading-5">
                                <p class="inline-flex text-cool-gray-600 truncate">
                                    <x-icon.cash class="text-cool-gray-400"/> {{ $item->email_edas }}
                                </p>
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->edas_id }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $item->roles }} </span>
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

    <!-- Save Transaction Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Edit User</x-slot>

            <x-slot name="content">
                <x-input.group for="roles" label="Roles" :error="$errors->first('editing.roles')">
                    <x-input.select wire:model="editing.roles" id="roles" name="roles">
                        <option value="International Reguler">International Reguler</option>
                        <option value="Indonesia Reguler">Indonesia Reguler</option>
                        <option value="International Student">International Student</option>
                        <option value="Indonesia Student">Indonesia Student</option>
                        <option value="Poster Reguler">Poster Regule</option>
                        <option value="Poster Student">Poster Student</option>
                        <option value="ADMIN">ADMIN</option>
                    </x-input.select>
                </x-input.group>
                
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
