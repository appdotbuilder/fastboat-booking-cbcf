import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';

interface Stats {
    totalBookings: number;
    paidBookings: number;
    pendingBookings: number;
    totalRevenue: number;
}

interface Booking {
    id: number;
    booking_code: string;
    full_name: string;
    departure_date: string;
    total_price: number;
    payment_status: string;
    boatTicket?: { name: string };
    tourPackage?: { name: string };
}

interface PopularItem {
    name: string;
    booking_count: number;
}

interface MonthlyRevenue {
    month: number;
    revenue: number;
}

interface Props {
    stats: Stats;
    recentBookings: Booking[];
    popularBoatTickets: PopularItem[];
    popularTourPackages: PopularItem[];
    monthlyRevenue: MonthlyRevenue[];
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ 
    stats, 
    recentBookings, 
    popularBoatTickets, 
    popularTourPackages, 
    monthlyRevenue 
}: Props) {
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(price);
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('id-ID');
    };

    const getStatusBadge = (status: string) => {
        switch (status) {
            case 'paid':
                return <span className="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Lunas</span>;
            case 'pending':
                return <span className="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Pending</span>;
            case 'cancelled':
                return <span className="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">Batal</span>;
            default:
                return status;
        }
    };

    const getMonthName = (month: number) => {
        const months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
        ];
        return months[month - 1];
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard Admin" />
            
            <div className="p-6">
                {/* Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900">📊 Dashboard Admin FastBoat</h1>
                    <p className="text-gray-600 mt-2">Selamat datang di panel admin sistem booking fastboat dan wisata</p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-3 bg-blue-100 rounded-lg">
                                <span className="text-2xl">📋</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Total Booking</p>
                                <p className="text-2xl font-bold text-blue-600">{stats?.totalBookings || 0}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-3 bg-green-100 rounded-lg">
                                <span className="text-2xl">✅</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Booking Lunas</p>
                                <p className="text-2xl font-bold text-green-600">{stats?.paidBookings || 0}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-3 bg-yellow-100 rounded-lg">
                                <span className="text-2xl">⏳</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Pending</p>
                                <p className="text-2xl font-bold text-yellow-600">{stats?.pendingBookings || 0}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <div className="flex items-center">
                            <div className="p-3 bg-purple-100 rounded-lg">
                                <span className="text-2xl">💰</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm text-gray-600">Total Revenue</p>
                                <p className="text-xl font-bold text-purple-600">{stats?.totalRevenue ? formatPrice(stats.totalRevenue) : formatPrice(0)}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Charts and Tables Row */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    {/* Monthly Revenue Chart */}
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <h2 className="text-xl font-bold text-gray-900 mb-4">📈 Revenue Bulanan</h2>
                        <div className="space-y-2">
                            {monthlyRevenue?.map((item) => (
                                <div key={item.month} className="flex justify-between items-center">
                                    <span className="text-gray-600">{getMonthName(item.month)}</span>
                                    <span className="font-medium">{formatPrice(item.revenue)}</span>
                                </div>
                            ))}
                            {(!monthlyRevenue || monthlyRevenue.length === 0) && (
                                <p className="text-gray-500 text-center py-4">Belum ada data revenue</p>
                            )}
                        </div>
                    </div>

                    {/* Popular Items */}
                    <div className="bg-white p-6 rounded-lg shadow-sm border">
                        <h2 className="text-xl font-bold text-gray-900 mb-4">🔥 Item Populer</h2>
                        
                        <div className="mb-6">
                            <h3 className="font-semibold text-gray-700 mb-2">🚤 Tiket Boat Terpopuler</h3>
                            <div className="space-y-2">
                                {popularBoatTickets?.slice(0, 3).map((item, index) => (
                                    <div key={index} className="flex justify-between items-center text-sm">
                                        <span className="text-gray-600">{item.name}</span>
                                        <span className="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {item.booking_count} booking
                                        </span>
                                    </div>
                                ))}
                                {(!popularBoatTickets || popularBoatTickets.length === 0) && (
                                    <p className="text-gray-500 text-sm">Belum ada data</p>
                                )}
                            </div>
                        </div>

                        <div>
                            <h3 className="font-semibold text-gray-700 mb-2">🏝️ Paket Wisata Terpopuler</h3>
                            <div className="space-y-2">
                                {popularTourPackages?.slice(0, 3).map((item, index) => (
                                    <div key={index} className="flex justify-between items-center text-sm">
                                        <span className="text-gray-600">{item.name}</span>
                                        <span className="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {item.booking_count} booking
                                        </span>
                                    </div>
                                ))}
                                {(!popularTourPackages || popularTourPackages.length === 0) && (
                                    <p className="text-gray-500 text-sm">Belum ada data</p>
                                )}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Recent Bookings */}
                <div className="bg-white rounded-lg shadow-sm border">
                    <div className="p-6">
                        <h2 className="text-xl font-bold text-gray-900 mb-4">📋 Booking Terbaru</h2>
                        
                        <div className="overflow-x-auto">
                            <table className="min-w-full table-auto">
                                <thead>
                                    <tr className="border-b">
                                        <th className="text-left py-3 px-4 font-semibold text-gray-700">Kode</th>
                                        <th className="text-left py-3 px-4 font-semibold text-gray-700">Customer</th>
                                        <th className="text-left py-3 px-4 font-semibold text-gray-700">Item</th>
                                        <th className="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                        <th className="text-left py-3 px-4 font-semibold text-gray-700">Total</th>
                                        <th className="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {recentBookings?.map((booking) => (
                                        <tr key={booking.id} className="border-b hover:bg-gray-50">
                                            <td className="py-3 px-4">
                                                <span className="font-mono text-sm bg-gray-100 px-2 py-1 rounded">
                                                    {booking.booking_code}
                                                </span>
                                            </td>
                                            <td className="py-3 px-4">
                                                <span className="font-medium">{booking.full_name}</span>
                                            </td>
                                            <td className="py-3 px-4">
                                                <span className="text-sm text-gray-600">
                                                    {booking.boatTicket?.name || booking.tourPackage?.name}
                                                </span>
                                            </td>
                                            <td className="py-3 px-4">
                                                <span className="text-sm">{formatDate(booking.departure_date)}</span>
                                            </td>
                                            <td className="py-3 px-4">
                                                <span className="font-medium">{formatPrice(booking.total_price)}</span>
                                            </td>
                                            <td className="py-3 px-4">
                                                {getStatusBadge(booking.payment_status)}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            
                            {(!recentBookings || recentBookings.length === 0) && (
                                <div className="text-center py-8">
                                    <p className="text-gray-500">Belum ada booking terbaru</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}