<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'priority' => [
                'required',
                'in:low,medium,high,urgent',
            ],
            'status' => [
                'required',
                'in:open,in_progress,resolved,closed',
            ],
            'requester_name' => [
                'required',
                'string',
                'max:100',
            ],
            'requester_email' => [
                'required',
                'email',
                'max:150',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul ticket wajib diisi.',
            'title.max' => 'Judul maksimal 150 karakter.',
            'category.required' => 'Kategori wajib diisi.',
            'priority.required' => 'Priority wajib dipilih.',
            'priority.in' => 'Priority harus low, medium, high, atau urgent.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus open, in_progress, resolved, atau closed.',
            'requester_name.required' => 'Nama pelapor wajib diisi.',
            'requester_email.required' => 'Email pelapor wajib diisi.',
            'requester_email.email' => 'Format email pelapor tidak valid.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi data gagal.',
                'data' => null,
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}