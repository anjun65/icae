<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Livewire\WithFileUploads;
use App\Models\Paper as PaperModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Paper extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithFileUploads;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'link_video' => '',
        'paper_code' => '',
        'paper_title' => '',
        'presenter_name' => '',
        'vita_presenter' => '',
    ];
    
    public PaperModel $editing;

    public $upload;
    public $user_id;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { return [
        'editing.paper_code' => 'required',
        'editing.paper_title' => 'required',
        'editing.link_video' => 'required',
        'editing.presenter_name' => 'required',
        'editing.vita_presenter' => 'required',
    ]; }

    public function mount() {
        $this->user_id = Auth::id();
        $this->editing = $this->makeBlankTransaction(); 
    }
    public function updatedFilters() { $this->resetPage(); }


    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted '.$deleteCount.' Data.');
    }

    public function makeBlankTransaction()
    {
        return PaperModel::make(['date' => now()]);
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
            'user_id' => Auth::id(),
        ]);

        $this->emitSelf('notify-saved');
        
        $this->notify('Data Saved Successfully');

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $query = PaperModel::query()
            ->when($this->user_id, fn($query, $user_id) => $query->where('user_id', $user_id))
            ->when($this->filters['paper_title'], fn($query, $paper_title) => $query->where('paper_title', 'like', '%'.$paper_title.'%'))
            ->when($this->filters['link_video'], fn($query, $link_video) => $query->where('link_video', 'like', '%'.$link_video.'%'))
            ->when($this->filters['presenter_name'], fn($query, $presenter_name) => $query->where('presenter_name', 'like', '%'.$presenter_name.'%'))
            ->when($this->filters['vita_presenter'], fn($query, $vita_presenter) => $query->where('vita_presenter', 'like', '%'.$vita_presenter.'%'))
            ->when($this->filters['paper_code'], fn($query, $paper_code) => $query->where('paper_code', 'like', '%'.$paper_code.'%'));

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
            'papers' => $this->rows,
        ]);
        
    }
}
