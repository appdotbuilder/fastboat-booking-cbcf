import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { useForm } from '@inertiajs/react';

interface BoatTicket {
    id: number;
    name: string;
    price: number;
    description: string;
    duration_hours: number;
    origin: string;
    destination: string;
}

interface TourPackage {
    id: number;
    name: string;
    price: number;
    description: string;
    duration_days: number;
}

interface Props {
    boatTickets: BoatTicket[];
    tourPackages: TourPackage[];
    heroTitle: string;
    heroDescription: string;
    [key: string]: unknown;
}

export default function Welcome({ boatTickets, tourPackages, heroTitle, heroDescription }: Props) {
    const [showBookingForm, setShowBookingForm] = useState(false);

    const { data, setData, post, processing, errors } = useForm({
        full_name: '',
        email: '',
        phone: '',
        booking_type: 'boat_ticket',
        boat_ticket_id: '',
        tour_package_id: '',
        departure_date: '',
        passenger_count: 1,
        payment_method: 'bank_transfer',
    });

    const handleBookingTypeChange = (type: string) => {
        setData('booking_type', type);
        setData('boat_ticket_id', '');
        setData('tour_package_id', '');
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('booking.store'), {
            onSuccess: () => {
                // Will be handled by the controller redirect
            },
        });
    };

    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(price);
    };

    const getTotalPrice = () => {
        let price = 0;
        if (data.booking_type === 'boat_ticket' && data.boat_ticket_id) {
            const ticket = boatTickets.find(t => t.id === parseInt(data.boat_ticket_id));
            price = ticket?.price || 0;
        } else if (data.booking_type === 'tour_package' && data.tour_package_id) {
            const pkg = tourPackages.find(p => p.id === parseInt(data.tour_package_id));
            price = pkg?.price || 0;
        }
        return price * data.passenger_count;
    };

    return (
        <>
            <Head title={heroTitle} />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-50">
                {/* Navigation */}
                <nav className="bg-white shadow-sm border-b">
                    <div className="container mx-auto px-4 py-4">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center space-x-4">
                                <div className="text-2xl font-bold text-blue-600">🚤 FastBoat</div>
                            </div>
                            <div className="hidden md:flex items-center space-x-8">
                                <a href="#home" className="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                                <a href="#tickets" className="text-gray-700 hover:text-blue-600 font-medium">Tiket Boat</a>
                                <a href="#packages" className="text-gray-700 hover:text-blue-600 font-medium">Paket Wisata</a>
                                <a href="#booking" className="text-gray-700 hover:text-blue-600 font-medium">Booking</a>
                                <a href="#contact" className="text-gray-700 hover:text-blue-600 font-medium">Kontak</a>
                            </div>
                            <div className="flex items-center space-x-4">
                                <a 
                                    href={route('login')} 
                                    className="text-blue-600 hover:text-blue-700 font-medium"
                                >
                                    Login Admin
                                </a>
                                <button
                                    onClick={() => setShowBookingForm(true)}
                                    className="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                >
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <section id="home" className="py-20 px-4">
                    <div className="container mx-auto text-center">
                        <h1 className="text-4xl md:text-6xl font-bold text-gray-800 mb-6">
                            {heroTitle}
                        </h1>
                        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                            {heroDescription}
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <button
                                onClick={() => setShowBookingForm(true)}
                                className="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-colors"
                            >
                                🎫 Book Tiket Sekarang
                            </button>
                            <button
                                onClick={() => document.getElementById('packages')?.scrollIntoView({ behavior: 'smooth' })}
                                className="border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors"
                            >
                                🏝️ Lihat Paket Wisata
                            </button>
                        </div>
                    </div>
                </section>

                {/* Boat Tickets Section */}
                <section id="tickets" className="py-16 bg-white">
                    <div className="container mx-auto px-4">
                        <h2 className="text-3xl font-bold text-center text-gray-800 mb-12">
                            🚤 Tiket Fastboat Tersedia
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {boatTickets.slice(0, 6).map((ticket) => (
                                <div key={ticket.id} className="bg-white rounded-lg shadow-lg border hover:shadow-xl transition-shadow">
                                    <div className="p-6">
                                        <h3 className="text-xl font-semibold text-gray-800 mb-2">{ticket.name}</h3>
                                        <p className="text-gray-600 mb-4 text-sm">{ticket.description}</p>
                                        <div className="flex justify-between items-center mb-4">
                                            <span className="text-2xl font-bold text-blue-600">{formatPrice(ticket.price)}</span>
                                            <span className="text-sm text-gray-500">⏱️ {ticket.duration_hours}h</span>
                                        </div>
                                        <div className="text-sm text-gray-600 mb-4">
                                            📍 {ticket.origin} → {ticket.destination}
                                        </div>
                                        <button
                                            onClick={() => {
                                                setData('booking_type', 'boat_ticket');
                                                setData('boat_ticket_id', ticket.id.toString());
                                                setShowBookingForm(true);
                                            }}
                                            className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                        >
                                            Book Tiket Ini
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Tour Packages Section */}
                <section id="packages" className="py-16 bg-gray-50">
                    <div className="container mx-auto px-4">
                        <h2 className="text-3xl font-bold text-center text-gray-800 mb-12">
                            🏝️ Paket Wisata Eksotis
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {tourPackages.slice(0, 6).map((pkg) => (
                                <div key={pkg.id} className="bg-white rounded-lg shadow-lg border hover:shadow-xl transition-shadow">
                                    <div className="p-6">
                                        <h3 className="text-xl font-semibold text-gray-800 mb-2">{pkg.name}</h3>
                                        <p className="text-gray-600 mb-4 text-sm line-clamp-3">{pkg.description}</p>
                                        <div className="flex justify-between items-center mb-4">
                                            <span className="text-2xl font-bold text-green-600">{formatPrice(pkg.price)}</span>
                                            <span className="text-sm text-gray-500">📅 {pkg.duration_days} hari</span>
                                        </div>
                                        <button
                                            onClick={() => {
                                                setData('booking_type', 'tour_package');
                                                setData('tour_package_id', pkg.id.toString());
                                                setShowBookingForm(true);
                                            }}
                                            className="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors font-medium"
                                        >
                                            Book Paket Ini
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Contact Section */}
                <section id="contact" className="py-16 bg-blue-600 text-white">
                    <div className="container mx-auto px-4 text-center">
                        <h2 className="text-3xl font-bold mb-8">📞 Hubungi Kami</h2>
                        <div className="grid md:grid-cols-3 gap-8">
                            <div>
                                <div className="text-2xl mb-2">📧</div>
                                <h3 className="text-lg font-semibold mb-2">Email</h3>
                                <p>info@fastboatbooking.com</p>
                            </div>
                            <div>
                                <div className="text-2xl mb-2">📱</div>
                                <h3 className="text-lg font-semibold mb-2">WhatsApp</h3>
                                <p>+62 812 3456 7890</p>
                            </div>
                            <div>
                                <div className="text-2xl mb-2">📍</div>
                                <h3 className="text-lg font-semibold mb-2">Office</h3>
                                <p>Sanur, Bali, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-800 text-white py-8">
                    <div className="container mx-auto px-4 text-center">
                        <div className="flex items-center justify-center space-x-2 mb-4">
                            <span className="text-2xl">🚤</span>
                            <span className="text-xl font-bold">FastBoat Booking</span>
                        </div>
                        <p className="text-gray-400">
                            Jelajahi keindahan Indonesia dengan layanan terpercaya © 2024
                        </p>
                    </div>
                </footer>

                {/* Booking Modal */}
                {showBookingForm && (
                    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                        <div className="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                            <div className="p-6">
                                <div className="flex justify-between items-center mb-6">
                                    <h2 className="text-2xl font-bold text-gray-800">📝 Form Booking</h2>
                                    <button
                                        onClick={() => setShowBookingForm(false)}
                                        className="text-gray-500 hover:text-gray-700 text-xl"
                                    >
                                        ✕
                                    </button>
                                </div>

                                <form onSubmit={handleSubmit} className="space-y-4">
                                    {/* Personal Info */}
                                    <div className="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                                Nama Lengkap *
                                            </label>
                                            <input
                                                type="text"
                                                value={data.full_name}
                                                onChange={(e) => setData('full_name', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Masukkan nama lengkap"
                                            />
                                            {errors.full_name && <p className="text-red-500 text-sm mt-1">{errors.full_name}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                                Email *
                                            </label>
                                            <input
                                                type="email"
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="contoh@email.com"
                                            />
                                            {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
                                        </div>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Nomor HP *
                                        </label>
                                        <input
                                            type="tel"
                                            value={data.phone}
                                            onChange={(e) => setData('phone', e.target.value)}
                                            className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="+62 812 3456 7890"
                                        />
                                        {errors.phone && <p className="text-red-500 text-sm mt-1">{errors.phone}</p>}
                                    </div>

                                    {/* Booking Type */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Tipe Booking *
                                        </label>
                                        <div className="grid grid-cols-2 gap-4">
                                            <button
                                                type="button"
                                                onClick={() => handleBookingTypeChange('boat_ticket')}
                                                className={`p-3 border rounded-lg text-center ${
                                                    data.booking_type === 'boat_ticket'
                                                        ? 'border-blue-500 bg-blue-50 text-blue-700'
                                                        : 'border-gray-300 hover:border-gray-400'
                                                }`}
                                            >
                                                🚤 Tiket Boat
                                            </button>
                                            <button
                                                type="button"
                                                onClick={() => handleBookingTypeChange('tour_package')}
                                                className={`p-3 border rounded-lg text-center ${
                                                    data.booking_type === 'tour_package'
                                                        ? 'border-green-500 bg-green-50 text-green-700'
                                                        : 'border-gray-300 hover:border-gray-400'
                                                }`}
                                            >
                                                🏝️ Paket Wisata
                                            </button>
                                        </div>
                                    </div>

                                    {/* Item Selection */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Pilih {data.booking_type === 'boat_ticket' ? 'Tiket' : 'Paket'} *
                                        </label>
                                        <select
                                            value={data.booking_type === 'boat_ticket' ? data.boat_ticket_id : data.tour_package_id}
                                            onChange={(e) => {
                                                if (data.booking_type === 'boat_ticket') {
                                                    setData('boat_ticket_id', e.target.value);
                                                } else {
                                                    setData('tour_package_id', e.target.value);
                                                }
                                            }}
                                            className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        >
                                            <option value="">Pilih {data.booking_type === 'boat_ticket' ? 'tiket' : 'paket'}...</option>
                                            {(data.booking_type === 'boat_ticket' ? boatTickets : tourPackages).map((item) => (
                                                <option key={item.id} value={item.id}>
                                                    {item.name} - {formatPrice(item.price)}
                                                </option>
                                            ))}
                                        </select>
                                        {data.booking_type === 'boat_ticket' && errors.boat_ticket_id && <p className="text-red-500 text-sm mt-1">{errors.boat_ticket_id}</p>}
                                        {data.booking_type === 'tour_package' && errors.tour_package_id && <p className="text-red-500 text-sm mt-1">{errors.tour_package_id}</p>}
                                    </div>

                                    {/* Date and Passengers */}
                                    <div className="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                                Tanggal Keberangkatan *
                                            </label>
                                            <input
                                                type="date"
                                                value={data.departure_date}
                                                onChange={(e) => setData('departure_date', e.target.value)}
                                                min={new Date().toISOString().split('T')[0]}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            />
                                            {errors.departure_date && <p className="text-red-500 text-sm mt-1">{errors.departure_date}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                                Jumlah Penumpang *
                                            </label>
                                            <input
                                                type="number"
                                                min="1"
                                                max="20"
                                                value={data.passenger_count}
                                                onChange={(e) => setData('passenger_count', parseInt(e.target.value))}
                                                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            />
                                            {errors.passenger_count && <p className="text-red-500 text-sm mt-1">{errors.passenger_count}</p>}
                                        </div>
                                    </div>

                                    {/* Payment Method */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">
                                            Metode Pembayaran *
                                        </label>
                                        <div className="space-y-2">
                                            <label className="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                                <input
                                                    type="radio"
                                                    value="bank_transfer"
                                                    checked={data.payment_method === 'bank_transfer'}
                                                    onChange={(e) => setData('payment_method', e.target.value)}
                                                    className="mr-3"
                                                />
                                                <div>
                                                    <div className="font-medium">🏧 Transfer Bank</div>
                                                    <div className="text-sm text-gray-600">Mandiri 1610003228298 a.n Lalu Yusran Said</div>
                                                </div>
                                            </label>
                                            <label className="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                                <input
                                                    type="radio"
                                                    value="office_payment"
                                                    checked={data.payment_method === 'office_payment'}
                                                    onChange={(e) => setData('payment_method', e.target.value)}
                                                    className="mr-3"
                                                />
                                                <div>
                                                    <div className="font-medium">🏢 Bayar di Office</div>
                                                    <div className="text-sm text-gray-600">Datang langsung ke kantor kami</div>
                                                </div>
                                            </label>
                                            <label className="flex items-center p-3 border rounded-lg cursor-not-allowed opacity-50">
                                                <input
                                                    type="radio"
                                                    value="credit_card"
                                                    disabled
                                                    className="mr-3"
                                                />
                                                <div>
                                                    <div className="font-medium">💳 Credit Card</div>
                                                    <div className="text-sm text-gray-600">Coming Soon</div>
                                                </div>
                                            </label>
                                        </div>
                                        {errors.payment_method && <p className="text-red-500 text-sm mt-1">{errors.payment_method}</p>}
                                    </div>

                                    {/* Total Price */}
                                    {getTotalPrice() > 0 && (
                                        <div className="bg-blue-50 p-4 rounded-lg">
                                            <div className="flex justify-between items-center">
                                                <span className="text-lg font-medium text-gray-700">Total Harga:</span>
                                                <span className="text-2xl font-bold text-blue-600">{formatPrice(getTotalPrice())}</span>
                                            </div>
                                        </div>
                                    )}

                                    {/* Submit Button */}
                                    <div className="flex gap-4">
                                        <button
                                            type="button"
                                            onClick={() => setShowBookingForm(false)}
                                            className="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                                        >
                                            Batal
                                        </button>
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50"
                                        >
                                            {processing ? 'Memproses...' : '🎫 Konfirmasi Booking'}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}