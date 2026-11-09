<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreArchiveFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('uploadFile', $this->route('archive'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Veuillez sélectionner au moins un fichier.',
            'files.*.mimes' => 'Seuls les fichiers PDF, DOC, DOCX, XLS, XLSX sont autorisés.',
            'files.*.max' => 'Chaque fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}
