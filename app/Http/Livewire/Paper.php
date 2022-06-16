<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Livewire\WithFileUploads;
use App\Models\Paper as PaperModel;

class Paper extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithFileUploads;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'search' => '',
        'paper_code' => '',
        'paper_title' => null,
        'presenter_name' => null,
        'vita_presenter' => null,
    ];
    
    public PaperModel $editing;

    public $upload;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { return [
        'editing.paper_code' => 'required',
        'editing.paper_title' => 'required',
        'editing.link_video' => 'required',
        'editing.presenter_name' => 'required',
        'editing.vita_presenter' => 'required',
    ]; }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }


    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('Anda telah menghapus '.$deleteCount.' data.');
    }

    public function makeBlankTransaction()
    {
        return PaperModel::make(['date' => now(), 'status' => 'success']);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();

        $this->showEditModal = true;
    }

    public function edit(PaperModel $transaction)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($transaction)) $this->editing = $transaction;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->editing->fill([
            'status' => 'Disetujui',
        ]);

        $this->emitSelf('notify-saved');
        
        $this->notify('Data berhasil disetujui');

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $query = PaperModel::query()
            ->when($this->filters['status'], fn($query, $status) => $query->where('status', $status))
            ->when($this->filters['perusahaan'], fn($query, $perusahaan) => $query->where('perusahaan', 'like', '%'.$perusahaan.'%'))
            ->when($this->filters['date-min'], fn($query, $date) => $query->where('awal_berlaku', '>=', Carbon::parse($date)))
            ->when($this->filters['date-max'], fn($query, $date) => $query->where('akhir_berlaku', '<=', Carbon::parse($date)))
            ->when($this->filters['search'], fn($query, $search) => $query->where('nomor_izin_impor', 'like', '%'.$search.'%'));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function download_surat($id) 
    {
        $download = PaperModel::findorFail($id);
        return response()->download(storage_path('app/'.$download->upload_dokumen));
    }

    public function rejected($id)
    {
        $items = PaperModel::findorFail($id);
        $items->update(array('status' => 'Ditolak'));
        
        $this->notify('Data berhasil ditolak');
        $this->showEditModal = false;
    }

    public function render()
    {
        return view('livewire.paper', [
            'paper' => $this->rows,
        ]);
        
    }
}
