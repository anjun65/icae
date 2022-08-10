<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Livewire\WithFileUploads;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentProof extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithFileUploads;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'file' => '',
        'tanggal' => '',
        'approval_status' => '',
        'verification_status' => '',
        'file_invoice' => '',
        'tanggal_transfer' => '',
        'nominal_transfer' => '',
    ];
    
    public Payment $editing;

    public $upload;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { return [
        'editing.file' => 'required',
        'editing.tanggal' => 'required',
        'editing.approval_status' => 'required',
        'editing.verification_status' => 'required',
        'editing.file_invoice' => 'required',
        'editing.tanggal_transfer' => 'required',
        'editing.nominal_transfer' => 'required',
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
        return Payment::make(['date' => now()]);
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

    public function edit(Payment $transaction)
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
        $query = Payment::query()
            ->when($this->filters['file'], fn($query, $paper_title) => $query->where('file', 'like', '%'.$file.'%'))
            ->when($this->filters['tanggal'], fn($query, $link_video) => $query->where('tanggal', 'like', '%'.$tanggal.'%'))
            ->when($this->filters['approval_status'], fn($query, $approval_status) => $query->where('approval_status', 'like', '%'.$approval_status.'%'))
            ->when($this->filters['verification_status'], fn($query, $verification_status) => $query->where('verification_status', 'like', '%'.$verification_status.'%'))
            ->when($this->filters['file_invoice'], fn($query, $file_invoice) => $query->where('file_invoice', 'like', '%'.$file_invoice.'%'))
            ->when($this->filters['nominal_transfer'], fn($query, $nominal_transfer) => $query->where('nominal_transfer', 'like', '%'.$nominal_transfer.'%'))
            ->when($this->filters['tanggal_transfer'], fn($query, $tanggal_transfer) => $query->where('tanggal_transfer', $tanggal_transfer));

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
        $download = Payment::findorFail($id);
        return response()->download(storage_path('app/'.$download->upload_dokumen));
    }

    public function rejected($id)
    {
        $items = Payment::findorFail($id);
        $items->update(array('status' => 'Ditolak'));
        
        $this->notify('Data berhasil ditolak');
        $this->showEditModal = false;
    }

    public function render()
    {
        return view('livewire.payment-proof', [
            'items' => $this->rows,
        ]);
        
    }
}


