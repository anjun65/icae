<div>
    <h1 class="text-2xl font-semibold text-gray-900">Paper</h1></h1>

    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filters.search" placeholder="Cari Paper..." />

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
            </div>
        </div>

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
            <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
                <div class="w-1/2 pr-2 space-y-4">
                    <x-input.group inline for="filter-status" label="Status">
                        <x-input.select wire:model="filters.status" id="filter-status">
                            <option value="" disabled>Select Status...</option>

                            @foreach (App\Models\IzinImpor::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group inline for="filter-perusahaan" label="Perusahaan">
                        <x-input.text wire:model.lazy="filters.perusahaan" id="filter-perusahaan" />
                    </x-input.group>
                </div>

                <div class="w-1/2 pl-2 space-y-4">
                    <x-input.group inline for="filter-date-min" label="Minimum Date">
                        <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="MM/DD/YYYY" />
                    </x-input.group>

                    <x-input.group inline for="filter-date-max" label="Maximum Date">
                        <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="MM/DD/YYYY" />
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
                    <x-table.heading sortable multi-column wire:click="sortBy('nomor_izin_impor')" :direction="$sorts['nomor_izin_impor'] ?? null">NO dan Tanggal Izin Impor</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('perusahaan')" :direction="$sorts['perusahaan'] ?? null">Perusahaan</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('awal_berlaku')" :direction="$sorts['awal_berlaku'] ?? null">MASA BERLAKU</x-table.heading>
                    <x-table.heading sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-table.heading>
                    
                    <x-table.heading />
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                    <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                        <x-table.cell colspan="8">
                            @unless ($selectAll)
                            <div>
                                <span>Anda telah memilih <strong>{{ $izins->count() }}</strong> data surat kuasa, Apakah anda mau pilih semua data <strong>{{ $izins->total() }}</strong>?</span>
                                <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                            </div>
                            @else
                            <span>Anda telah memilih <strong>{{ $izins->total() }}</strong> data.</span>
                            @endif
                        </x-table.cell>
                    </x-table.row>
                    @endif

                    @forelse ($izins as $izin)
                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $izin->id }}">
                        <x-table.cell class="pr-0">
                            <x-input.checkbox wire:model="selected" value="{{ $izin->id }}" />
                        </x-table.cell>

                        <x-table.cell>
                            <span href="#" class="truncate text-sm leading-5">
                                

                                <p class="inline-flex text-cool-gray-600 truncate">
                                    <x-icon.cash class="text-cool-gray-400"/> {{ $izin->nomor_izin_impor }}
                                </p>
                                <p class="text-cool-gray-600 truncate pl-0">
                                    {{ $izin->tanggal_izin }}
                                </p>
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="text-cool-gray-900 font-medium">{{ $izin->perusahaan }} </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span href="#" class="text-sm leading-5">
                                <p class="text-cool-gray-600 truncate">
                                    {{ $izin->awal_berlaku }}
                                </p>
                                <p class="text-cool-gray-600 truncate">Sampai</p>
                                <p class="text-cool-gray-600 truncate">{{ $izin->akhir_berlaku }}</p>
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $izin->status_color }}-100 text-{{ $izin->status_color }}-800 capitalize">
                                {{ $izin->status }}
                            </span>
                        </x-table.cell>

                        <x-table.cell>
                            <x-button.link wire:click="edit({{ $izin->id }})">Edit</x-button.link>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                    <x-table.row>
                        <x-table.cell colspan="8">
                            <div class="flex justify-center items-center space-x-2">
                                <x-icon.inbox class="h-8 w-8 text-cool-gray-400" />
                                <span class="font-medium py-8 text-cool-gray-400 text-xl">Tidak ada izin impor yang ditemukan...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div>
                {{ $izins->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Transactions Modal -->
    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Hapus Surat Izin</x-slot>

            <x-slot name="content">
                <div class="py-8 text-cool-gray-700">Apakah anda yakin? Data yang telah dihapus tidak dapat dikembalikan.</div>
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
            <x-slot name="title">Izin Impor</x-slot>

            <x-slot name="content">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Data Pemberi Kuasa
                </h3>

                <x-input.group for="npwp_perusahaan" label="NPWP Perusahaan" :error="$errors->first('editing.npwp_perusahaan')">
                    <x-input.text disabled wire:model="editing.npwp_perusahaan" id="npwp_perusahaan" placeholder="NPWP Perusahaan" />
                </x-input.group>

                <x-input.group for="perusahaan" label="Nama Perusahaan" :borderless="true" :error="$errors->first('editing.perusahaan')">
                    <x-input.text disabled wire:model="editing.perusahaan" id="perusahaan" placeholder="Nama Perusahaan" />
                </x-input.group>

                <x-input.group for="alamat_perusahaan" label="Alamat Perusahaan" :borderless="true" :error="$errors->first('editing.alamat_perusahaan')">
                    <x-input.text disabled wire:model="editing.alamat_perusahaan" id="alamat_perusahaan" placeholder="Alamat Perusahaan" />
                </x-input.group>

                <x-input.group for="nomor_izin_bpk" label="Nomor Ijin BPK" :borderless="true" :error="$errors->first('editing.nomor_izin_bpk')">
                    <x-input.text disabled wire:model="editing.nomor_izin_bpk" id="nomor_izin_bpk" placeholder="Nomor Ijin BPK" />
                </x-input.group>

                <x-input.group for="tanggal_izin" label="Tanggal Ijin BPK" :borderless="true" :error="$errors->first('editing.tanggal_izin')">
                    <x-input.date disabled wire:model="editing.tanggal_izin" id="tanggal_ijin_bpk" />
                </x-input.group>

                <h3 class="text-xl pt-2 font-medium text-gray-900 dark:text-white">
                    Data Izin Pemasukan Barang BP Kawasan
                </h3>

                <x-input.group for="nomor_surat" label="Nomor Surat" :error="$errors->first('editing.nomor_surat')">
                    <x-input.text disabled wire:model="editing.nomor_surat" id="nomor_surat" placeholder="Nomor Surat" />
                </x-input.group>

                <x-input.group for="tanggal_surat" label="Tanggal Surat" :borderless="true" :error="$errors->first('editing.tanggal_surat')">
                    <x-input.date disabled wire:model="editing.tanggal_surat" id="tanggal_ijin_bpk" />
                </x-input.group>

                <x-input.group for="kantor_bc_ftz" label="Kantor BC FTZ" :error="$errors->first('editing.kantor_bc_ftz')">
                    <x-input.select disabled wire:model="editing.kantor_bc_ftz" id="kantor_bc_ftz">
                            <option value="" disabled selected>Pilih Kantor BC</option>
                            <option value="DIREKTORAT IKC">DIREKTORAT IKC</option>
                            <option value="KPPBC TMP B TANJUNG BALAI KARIMUN">KPPBC TMP B TANJUNG BALAI KARIMUN</option>
                            <option value="KPU BEA DAN CUKAI TIPE B BATAM">KPU BEA DAN CUKAI TIPE B BATAM</option>
                            <option value="KPPBC TMP B TANJUNG PINANG">KPPBC TMP B TANJUNG PINANG</option>
                            <option value="KPPBC TMP C SABANG">KPPBC TMP C SABANG</option>
                    </x-input.select>
                </x-input.group>

                @if(App\Models\IzinImpor::count() >= 1)
                   <x-input.group label="Upload File" for="photo" :error="$errors->first('upload')">
                        <x-button.secondary wire:click="download_surat({{ $izin->id }})">
                            Download File
                        </x-button.secondary>
                    </x-input.group>                    
                @endif
                

                <x-input.group for="awal_berlaku" label="Tanggal Awal" :borderless="true" :error="$errors->first('editing.awal_berlaku')">
                    <x-input.date disabled wire:model="editing.awal_berlaku" id="tanggal_awal" />
                </x-input.group>

                <x-input.group for="akhir_berlaku" label="Tanggal Akhir" :borderless="true" :error="$errors->first('editing.akhir_berlaku')">
                    <x-input.date disabled wire:model="editing.akhir_berlaku" id="akhir_berlaku" />
                </x-input.group>

                

            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>
                
                @if(App\Models\IzinImpor::count() >= 1)
                    <button type="button" wire:click="rejected({{ $izin->id }})" class="bg-red-800 text-white py-2 px-4 border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out border-gray-300 text-white active:bg-red-900 active:text-white hover:text-white">Reject</button>
                @endif
                <x-button.primary type="submit">Approve</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
