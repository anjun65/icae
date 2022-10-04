<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Livewire\WithFileUploads;
use App\Models\Payment;
use App\Models\Paper;
use App\Models\Poster;
use Barryvdh\DomPDF\Facade\Pdf;
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
        'tanggal_transfer' => '',
        'nominal_transfer' => '',
    ];
    
    public Payment $editing;

    public $upload_bayar;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { return [
        'editing.file' => 'required',
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
        
        // $this->editing->fill([
        //     'user_id' => Auth::id(),
        //     'file' => $this->upload_bayar->store('assets/payment','public'),
        //     'approval_status' => "Diajukan",
        //     'verification_status' => "Diajukan",
        // ]);

        

        $this->emitSelf('notify-saved');
        
        $this->notify('Data Saved Successfully');

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $query = Payment::query()
            ->when($this->filters['file'], fn($query, $file) => $query->where('file', 'like', '%'.$file.'%'))
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

    public function invoice($id) 
    {
        
        $item = Payment::findorFail($id);
        // $user = User::findorFail($item->user_id)->toArray();
        $paper = Paper::where('user_id', $item->user_id)->get();
        $poster = Poster::where('user_id', $item->user_id)->get();

        
        $berkas = "Invoice";

        view()->share([
            'item'=> $item,
            'paper'=> $paper,
            'poster'=> $poster,
        ]);

        $pdfContent = PDF::loadView('pdf.invoice',[
            'item'=> $item,
            'papers'=> $paper,
            'posters'=> $poster,
        ])->setPaper('a4', 'portrait')->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            $berkas."000".$item->id.".pdf"
        );
        
    }

    public function kwitansi($id) 
    {
        $item = Payment::findorFail($id);
        if ($item->verification_status == 'Approved'){
            
            $paper = Paper::where('user_id', $item->user_id)->get();
            $poster = Poster::where('user_id', $item->user_id)->get();

            $berkas = "Kwitansi";

            view()->share([
                'item'=> $item,
                'paper'=> $paper,
                'poster'=> $poster,
            ]);

            $pdfContent = PDF::loadView('pdf.invoice',[
                'item'=> $item,
                'papers'=> $paper,
                'posters'=> $poster,
            ])->setPaper('a4', 'portrait')->output();
            return response()->streamDownload(
                fn () => print($pdfContent),
                $berkas."000".$item->id.".pdf"
            );
        }
    }

    public function rejected($id)
    {
        
        $items = Payment::findorFail($id);

        $items->update(['verification_status' => 'Rejected']);
        $items->update(['approval_status' => 'Rejected']);

        $this->showEditModal = false;
    }

    public function approved($id)
    {
        $items = Payment::findorFail($id);
        $items->update(['verification_status' => 'Approved']);
        $items->update(['approval_status' => 'Approved']);
        
        $this->notify('Data berhasil ditolak');
        $this->showEditModal = false;
    }

    public function render()
    {
        return view('livewire.admin.payment-proof', [
            'items' => $this->rows,
        ]);
        
    }
}


