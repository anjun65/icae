<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Users extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithFileUploads;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'name' => '',
    ];
    
    public User $editing;

    public $upload;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { return [
        'editing.roles' => 'required',
    ]; }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
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
        return User::make(['date' => now()]);
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

    public function edit(User $transaction)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($transaction)) $this->editing = $transaction;

        $this->showEditModal = true;
    }

    public function save()
    {
    
        $this->emitSelf('notify-saved');
        
        $this->notify('Data Saved Successfully');

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $query = User::query()
            ->when($this->filters['name'], fn($query, $name) => $query->where('name', 'like', '%'.$name.'%'));

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
        $download = User::findorFail($id);
        return response()->download(storage_path('app/'.$download->upload_dokumen));
    }

    public function rejected($id)
    {
        $items = User::findorFail($id);
        $items->update(array('status' => 'Ditolak'));
        
        $this->notify('Data berhasil ditolak');
        $this->showEditModal = false;
    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'users.csv');
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'items' => $this->rows,
        ]);
        
    }
}
