<?php

namespace App\Livewire\Dashboard;

use App\Models\ApplicationDocument;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.dashboard')]
class DocumentManager extends Component
{
    use WithFileUploads;

    public $upload;
    public $type = 'resume'; // default type
    public $title;
    
    public $filterType = '';

    protected $rules = [
        'upload' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png', // 10MB max
        'title' => 'required|string|max:255',
        'type' => 'required|string|in:resume,essay,transcript,other',
    ];

    public function updatedUpload()
    {
        $this->validateOnly('upload');
        if (!$this->title) {
            $this->title = pathinfo($this->upload->getClientOriginalName(), PATHINFO_FILENAME);
        }
    }

    public function save()
    {
        $this->validate();

        $path = $this->upload->store('documents/' . auth()->id(), 'public');

        auth()->user()->applicationDocuments()->create([
            'title' => $this->title,
            'type' => $this->type,
            'path' => $path,
            'mime_type' => $this->upload->getMimeType(),
            'size' => $this->upload->getSize(),
        ]);

        $this->reset(['upload', 'title', 'type']);
        $this->dispatch('notify', message: 'Document uploaded successfully.');
    }

    public function delete($id)
    {
        $document = auth()->user()->applicationDocuments()->findOrFail($id);
        
        if (Storage::disk('public')->exists($document->path)) {
            Storage::disk('public')->delete($document->path);
        }

        $document->delete();
        $this->dispatch('notify', message: 'Document deleted.');
    }

    public function download($id)
    {
        $document = auth()->user()->applicationDocuments()->findOrFail($id);
        
        if (Storage::disk('public')->exists($document->path)) {
            return response()->download(storage_path('app/public/' . $document->path), $document->title . '.' . pathinfo($document->path, PATHINFO_EXTENSION));
        }

        $this->dispatch('notify', message: 'File not found.');
    }

    public function render()
    {
        $documents = auth()->user()->applicationDocuments()
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->latest()
            ->get();

        return view('livewire.dashboard.document-manager', [
            'documents' => $documents,
        ]);
    }
}
