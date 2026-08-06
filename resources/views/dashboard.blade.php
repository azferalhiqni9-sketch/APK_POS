@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')

@section('content')

    

    <div style="background-color: #f8f9fa; min-height: 100vh; padding: 30px 20px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            
            {{-- Header Title & Date --}}
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #dee2e6; padding-bottom: 15px; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h2 style="font-weight: 700; color: #333; margin: 0; font-size: 24px;">Ringkasan Hari Ini</h2>
                    <p style="color: #6c757d; margin: 5px 0 0 0; font-size: 14px;">Monitor performa penjualan dan status inventaris toko secara real-time.</p>
                </div>
                <div style="background: white; border: 1px solid #ced4da; padding: 8px 15px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <span style="color: #495057; font-weight: 500; font-size: 14px;">
                        📅 {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>

            @can('viewAny', App\Models\User::class)
                {{-- Today's Sales Section --}}
                <div style="margin-bottom: 30px;">
                    <h4 style="font-size: 16px; font-weight: 700; color: #495057; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">
                        📊 Today's Sales
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        
                        <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border-left: 4px solid #0d6efd;">
                            <span style="color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Nilai Penjualan Hari Ini</span>
                            <h3 style="color: #212529; font-weight: 700; margin: 10px 0 0 0; font-size: 22px;">
                                Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}
                            </h3>
                        </div>

                        <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border-left: 4px solid #198754;">
                            <span style="color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Jumlah Transaksi Hari Ini</span>
                            <h3 style="color: #212529; font-weight: 700; margin: 10px 0 0 0; font-size: 22px;">
                                {{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} <span style="font-size: 14px; font-weight: 400; color: #6c757d;">Transaksi</span>
                            </h3>
                        </div>

                    </div>
                </div>

                {{-- Cash & Payment Status Section --}}
                <div style="margin-bottom: 30px;">
                    <h4 style="font-size: 16px; font-weight: 700; color: #495057; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">
                        💳 Cash & Payment Status
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        
                        <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 5px;">Total Pembayaran Tunai</span>
                                <h4 style="color: #198754; font-weight: 700; margin: 0; font-size: 18px;">
                                    Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}
                                </h4>
                            </div>
                            <span style="background: #d1e7dd; color: #0f5132; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Cash</span>
                        </div>

                        <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 5px;">Total Pembayaran Non-Tunai</span>
                                <h4 style="color: #0dcaf0; font-weight: 700; margin: 0; font-size: 18px;">
                                    Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}
                                </h4>
                            </div>
                            <span style="background: #cff4fc; color: #055160; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Non-Tunai</span>
                        </div>

                    </div>
                </div>
            @endcan

            {{-- Critical Inventory Status --}}
            <div style="margin-bottom: 30px;">
                <h4 style="font-size: 16px; font-weight: 700; color: #495057; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">
                    ⚠️ Critical Inventory Status
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    
                    {{-- Produk Rendah Stok --}}
                    <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                        <h5 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 15px;">Daftar Produk Rendah Stok</h5>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                                <thead>
                                    <tr style="background-color: #f1f3f5; color: #495057;">
                                        <th style="padding: 10px; border-bottom: 1px solid #dee2e6; width: 40px;">#</th>
                                        <th style="padding: 10px; border-bottom: 1px solid #dee2e6;">Nama Produk</th>
                                        <th style="padding: 10px; border-bottom: 1px solid #dee2e6; text-align: center; width: 80px;">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokRendah as $index => $produk)
                                        <tr>
                                            <td style="padding: 10px; border-bottom: 1px solid #f1f3f5; color: #6c757d;">{{ $produkStokRendah->firstItem() + $index }}</td>
                                            <td style="padding: 10px; border-bottom: 1px solid #f1f3f5; font-weight: 500; color: #212529;">{{ $produk->nama }}</td>
                                            <td style="padding: 10px; border-bottom: 1px solid #f1f3f5; text-align: center;">
                                                <span style="background: #fff3cd; color: #664d03; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">{{ $produk->stok }} Pcs</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" style="padding: 20px; text-align: center; color: #6c757d;">
                                                ✅ Seluruh produk berada dalam kondisi stok aman.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 15px;">
                            {{ $produkStokRendah->links() }}
                        </div>
                    </div>

                    {{-- Produk Habis Stok --}}
                    <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                        <h5 style="font-size: 14px; font-weight: 700; color: #333; margin-bottom: 15px;">Produk Habis Stok</h5>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                                <thead>
                                    <tr style="background-color: #f1f3f5; color: #495057;">
                                        <th style="padding: 10px; border-bottom: 1px solid #dee2e6; width: 40px;">#</th>
                                        <th style="padding: 10px; border-bottom: 1px solid #dee2e6;">Nama Produk</th>
                                        <th style="padding: 10px; border-bottom: 1px solid #dee2e6; text-align: center; width: 80px;">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokHabis as $produk)
                                        <tr>
                                            <td style="padding: 10px; border-bottom: 1px solid #f1f3f5; color: #6c757d;">{{ $loop->iteration }}</td>
                                            <td style="padding: 10px; border-bottom: 1px solid #f1f3f5; font-weight: 500; color: #212529;">{{ $produk->nama }}</td>
                                            <td style="padding: 10px; border-bottom: 1px solid #f1f3f5; text-align: center;">
                                                <span style="background: #f8d7da; color: #842029; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">Habis</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" style="padding: 20px; text-align: center; color: #6c757d;">
                                                ✅ Seluruh produk berada dalam kondisi stok aman.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 15px;">
                            {{ $produkStokHabis->links() }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Best Seller Products --}}
            <div style="margin-bottom: 20px;">
                <h4 style="font-size: 16px; font-weight: 700; color: #495057; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">
                    🔥 Best Seller Products
                </h4>
                <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                            <thead>
                                <tr style="background-color: #f1f3f5; color: #495057;">
                                    <th style="padding: 12px; border-bottom: 1px solid #dee2e6;">Nama Produk</th>
                                    <th style="padding: 12px; border-bottom: 1px solid #dee2e6; width: 150px;">Stok Tersisa</th>
                                    <th style="padding: 12px; border-bottom: 1px solid #dee2e6; width: 150px;">Unit Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkTerlaris as $produk)
                                    <tr>
                                        <td style="padding: 12px; border-bottom: 1px solid #f1f3f5; font-weight: 500; color: #212529;">{{ $produk->nama }}</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #f1f3f5; color: #6c757d;">{{ $produk->stok }} Pcs</td>
                                        <td style="padding: 12px; border-bottom: 1px solid #f1f3f5;">
                                            <span style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-weight: 700;">{{ $produk->total_terjual }} Terjual</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="padding: 20px; text-align: center; color: #6c757d;">
                                            Belum ada data penjualan produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection