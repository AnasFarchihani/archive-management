<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ArchiveStatus;
use App\Enums\DocumentType;
use Illuminate\Validation\Rule;

class StoreArchiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Archive::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document_number' => ['required', 'string', 'max:255', 'unique:archives,document_number'],
            'title' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string'],
            'sender' => ['nullable', 'string', 'max:255'],
            'submission_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:submission_date'],
            'archive_status' => ['required', Rule::enum(ArchiveStatus::class)],
            'document_type' => ['required', Rule::enum(DocumentType::class)],
            'notes' => ['nullable', 'string'],
            'storage_location_id' => ['required', 'exists:storage_locations,id'],
            'files' => ['nullable', 'array'],
            'files.*' => [
                'file',
                'mimes:pdf,doc,docx,xls,xlsx',
                'max:10240', // 10 MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'document_number.required' => 'Le numéro de document est obligatoire.',
            'document_number.unique' => 'Ce numéro de document existe déjà.',
            'title.required' => 'Le titre est obligatoire.',
            'submission_date.required' => 'La date de dépôt est obligatoire.',
            'storage_location_id.required' => 'L\'emplacement est obligatoire.',
            'files.*.mimes' => 'Seuls les fichiers PDF, DOC, DOCX, XLS, XLSX sont autorisés.',
            'files.*.max' => 'Chaque fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}
