<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'booking_type' => 'required|in:boat_ticket,tour_package',
            'boat_ticket_id' => 'required_if:booking_type,boat_ticket|nullable|exists:boat_tickets,id',
            'tour_package_id' => 'required_if:booking_type,tour_package|nullable|exists:tour_packages,id',
            'departure_date' => 'required|date|after:today',
            'passenger_count' => 'required|integer|min:1|max:20',
            'payment_method' => 'required|in:bank_transfer,office_payment,credit_card',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'booking_type.required' => 'Tipe booking wajib dipilih.',
            'boat_ticket_id.required_if' => 'Tiket boat wajib dipilih.',
            'tour_package_id.required_if' => 'Paket wisata wajib dipilih.',
            'departure_date.required' => 'Tanggal keberangkatan wajib diisi.',
            'departure_date.after' => 'Tanggal keberangkatan harus setelah hari ini.',
            'passenger_count.required' => 'Jumlah penumpang wajib diisi.',
            'passenger_count.min' => 'Jumlah penumpang minimal 1 orang.',
            'passenger_count.max' => 'Jumlah penumpang maksimal 20 orang.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ];
    }
}