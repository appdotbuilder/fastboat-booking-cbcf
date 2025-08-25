import React from 'react';
import { Head, Link } from '@inertiajs/react';

interface BoatTicket {
    id: number;
    name: string;
    price: number;
    origin: string;
    destination: string;
}

interface TourPackage {
    id: number;
    name: string;
    price: number;
    duration_days: number;
}

interface Booking {
    id: number;
    booking_code: string;
    full_name: string;
    email: string;
    phone: string;
    booking_type: string;
    departure_date: string;
    passenger_count: number;
    total_price: number;
    payment_method: string;
    payment_status: string;
    qr_code: string;
    boatTicket?: BoatTicket;
    tourPackage?: TourPackage;
}

interface Props {
    booking: Booking;
    [key: string]: unknown;
}

export default function BookingSuccess({ booking }: Props) {
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(price);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };

    const getPaymentMethodText = (method: string) => {
        switch (method) {
            case 'bank_transfer':
                return '🏧 Transfer Bank';
            case 'office_payment':
                return '🏢 Bayar di Office';
            case 'credit_card':
                return '💳 Credit Card';
            default:
                return method;
        }
    };

    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'paid':
                return <span className="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">✅ Lunas</span>;
            case 'pending':
                return <span className="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">⏳ Menunggu Pembayaran</span>;
            case 'cancelled':
                return <span className="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">❌ Dibatalkan</span>;
            default:
                return status;
        }
    };

    return (
        <>
            <Head title="Booking Berhasil" />
            
            <div className="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50">
                {/* Navigation */}
                <nav className="bg-white shadow-sm border-b">
                    <div className="container mx-auto px-4 py-4">
                        <div className="flex items-center justify-between">
                            <Link href={route('home')} className="flex items-center space-x-4">
                                <div className="text-2xl font-bold text-blue-600">🚤 FastBoat</div>
                            </Link>
                            <Link 
                                href={route('home')} 
                                className="text-blue-600 hover:text-blue-700 font-medium"
                            >
                                ← Kembali ke Home
                            </Link>
                        </div>
                    </div>
                </nav>

                {/* Success Content */}
                <div className="container mx-auto px-4 py-8">
                    <div className="max-w-4xl mx-auto">
                        {/* Success Header */}
                        <div className="text-center mb-8">
                            <div className="text-6xl mb-4">🎉</div>
                            <h1 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                                Booking Berhasil!
                            </h1>
                            <p className="text-xl text-gray-600">
                                Terima kasih telah mempercayai kami. E-ticket akan segera dikirim ke email Anda.
                            </p>
                        </div>

                        {/* Booking Details Card */}
                        <div className="bg-white rounded-lg shadow-lg border p-6 md:p-8 mb-6">
                            <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                                <div>
                                    <h2 className="text-2xl font-bold text-gray-800 mb-2">Detail Booking</h2>
                                    <p className="text-gray-600">Kode Booking: <span className="font-bold text-blue-600">{booking.booking_code}</span></p>
                                </div>
                                <div className="mt-4 md:mt-0">
                                    {getStatusBadge(booking.payment_status)}
                                </div>
                            </div>

                            {/* Customer Info */}
                            <div className="grid md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h3 className="font-semibold text-gray-800 mb-3">👤 Informasi Pemesan</h3>
                                    <div className="space-y-2 text-sm">
                                        <p><span className="text-gray-600">Nama:</span> <span className="font-medium">{booking.full_name}</span></p>
                                        <p><span className="text-gray-600">Email:</span> <span className="font-medium">{booking.email}</span></p>
                                        <p><span className="text-gray-600">HP:</span> <span className="font-medium">{booking.phone}</span></p>
                                    </div>
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-800 mb-3">📋 Detail Perjalanan</h3>
                                    <div className="space-y-2 text-sm">
                                        <p><span className="text-gray-600">Tanggal:</span> <span className="font-medium">{formatDate(booking.departure_date)}</span></p>
                                        <p><span className="text-gray-600">Penumpang:</span> <span className="font-medium">{booking.passenger_count} orang</span></p>
                                        <p><span className="text-gray-600">Pembayaran:</span> <span className="font-medium">{getPaymentMethodText(booking.payment_method)}</span></p>
                                    </div>
                                </div>
                            </div>

                            {/* Booking Item */}
                            <div className="border-t pt-6">
                                <h3 className="font-semibold text-gray-800 mb-3">
                                    {booking.booking_type === 'boat_ticket' ? '🚤 Tiket Boat' : '🏝️ Paket Wisata'}
                                </h3>
                                
                                {booking.boatTicket && (
                                    <div className="bg-blue-50 p-4 rounded-lg">
                                        <h4 className="font-semibold text-blue-800 mb-2">{booking.boatTicket.name}</h4>
                                        <div className="text-sm text-blue-700">
                                            <p>📍 {booking.boatTicket.origin} → {booking.boatTicket.destination}</p>
                                            <p>💰 {formatPrice(booking.boatTicket.price)} x {booking.passenger_count} orang</p>
                                        </div>
                                    </div>
                                )}

                                {booking.tourPackage && (
                                    <div className="bg-green-50 p-4 rounded-lg">
                                        <h4 className="font-semibold text-green-800 mb-2">{booking.tourPackage.name}</h4>
                                        <div className="text-sm text-green-700">
                                            <p>📅 {booking.tourPackage.duration_days} hari</p>
                                            <p>💰 {formatPrice(booking.tourPackage.price)} x {booking.passenger_count} orang</p>
                                        </div>
                                    </div>
                                )}
                            </div>

                            {/* Total Price */}
                            <div className="border-t pt-4 mt-4">
                                <div className="flex justify-between items-center">
                                    <span className="text-lg font-medium text-gray-700">Total Harga:</span>
                                    <span className="text-2xl font-bold text-green-600">{formatPrice(booking.total_price)}</span>
                                </div>
                            </div>
                        </div>

                        {/* QR Code */}
                        <div className="bg-white rounded-lg shadow-lg border p-6 md:p-8 mb-6">
                            <div className="text-center">
                                <h3 className="text-xl font-bold text-gray-800 mb-4">QR Code Check-in</h3>
                                <div className="inline-block bg-gray-100 p-6 rounded-lg">
                                    <div className="w-32 h-32 bg-white border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                                        <div className="text-center">
                                            <div className="text-2xl mb-2">📱</div>
                                            <div className="text-xs text-gray-500">QR Code akan dikirim via email</div>
                                        </div>
                                    </div>
                                </div>
                                <p className="text-sm text-gray-600 mt-4">
                                    Kode: <span className="font-mono bg-gray-100 px-2 py-1 rounded">{booking.qr_code}</span>
                                </p>
                            </div>
                        </div>

                        {/* Payment Instructions */}
                        {booking.payment_status === 'pending' && booking.payment_method === 'bank_transfer' && (
                            <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-6 md:p-8 mb-6">
                                <h3 className="text-xl font-bold text-yellow-800 mb-4">💳 Instruksi Pembayaran</h3>
                                <div className="text-yellow-700 space-y-2">
                                    <p>Silakan transfer sebesar <span className="font-bold">{formatPrice(booking.total_price)}</span> ke:</p>
                                    <div className="bg-yellow-100 p-4 rounded-lg mt-4">
                                        <p className="font-bold">Bank Mandiri</p>
                                        <p>No. Rekening: <span className="font-mono">1610003228298</span></p>
                                        <p>a.n: <span className="font-semibold">Lalu Yusran Said</span></p>
                                    </div>
                                    <p className="text-sm mt-4">
                                        Setelah transfer, mohon kirim bukti transfer ke WhatsApp: <span className="font-semibold">+62 812 3456 7890</span>
                                    </p>
                                </div>
                            </div>
                        )}

                        {/* Office Payment */}
                        {booking.payment_status === 'pending' && booking.payment_method === 'office_payment' && (
                            <div className="bg-blue-50 border border-blue-200 rounded-lg p-6 md:p-8 mb-6">
                                <h3 className="text-xl font-bold text-blue-800 mb-4">🏢 Pembayaran di Office</h3>
                                <div className="text-blue-700 space-y-2">
                                    <p>Silakan datang ke kantor kami untuk melakukan pembayaran:</p>
                                    <div className="bg-blue-100 p-4 rounded-lg mt-4">
                                        <p className="font-bold">FastBoat Booking Office</p>
                                        <p>📍 Jl. Bypass Ngurah Rai No. 123, Sanur, Bali 80228</p>
                                        <p>⏰ Jam Operasional: 08:00 - 18:00 WITA</p>
                                        <p>📞 Telepon: +62 812 3456 7890</p>
                                    </div>
                                    <p className="text-sm mt-4">
                                        Bawa kode booking <span className="font-bold">{booking.booking_code}</span> saat datang ke office.
                                    </p>
                                </div>
                            </div>
                        )}

                        {/* Actions */}
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link
                                href={route('home')}
                                className="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-colors text-center"
                            >
                                🏠 Kembali ke Home
                            </Link>
                            <button
                                onClick={() => window.print()}
                                className="border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors"
                            >
                                🖨️ Print Booking
                            </button>
                        </div>

                        {/* Contact Info */}
                        <div className="text-center mt-8">
                            <p className="text-gray-600">
                                Ada pertanyaan? Hubungi kami di <span className="font-semibold">📞 +62 812 3456 7890</span> atau 
                                <span className="font-semibold"> 📧 info@fastboatbooking.com</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}