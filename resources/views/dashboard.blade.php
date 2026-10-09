<x-app-layout>
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(Auth::user()->role === 'admin')
        <!-- Stat Cards menggunakan Card component (Acara 12) -->
        @php
            $stats = [
                ['label' => 'Total Barang', 'value' => $totalBarang, 'icon' => 'fa-cube', 'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'],
                ['label' => 'Total Kategori', 'value' => $totalKategori, 'icon' => 'fa-tags', 'gradient' => 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)'],
                ['label' => 'Barang Dipinjam', 'value' => $barangDipinjam, 'icon' => 'fa-hand-holding', 'gradient' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'],
                ['label' => 'Total Stok', 'value' => $barangTersedia, 'icon' => 'fa-warehouse', 'gradient' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'],
            ];
        @endphp

        <div class="stat-grid">
            @foreach($stats as $s)
                <div class="stat-card-custom" style="background: {{ $s['gradient'] }};">
                    <div class="flex justify-between items-start">
                        <span class="label">{{ $s['label'] }}</span>
                        <i class="fas {{ $s['icon'] }} text-2xl opacity-75"></i>
                    </div>
                    <div class="value">{{ $s['value'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Transaksi Terbaru dengan Card & DataTable Component -->
            <x-card header="Transaksi Terbaru" icon="fas fa-clock" icon-bg="#e8faf0" icon-color="#0d6832">
                <x-data-table :headers="[
                    ['label' => '#', 'width' => '50px'],
                    ['label' => 'Peminjam'],
                    ['label' => 'Barang'],
                    ['label' => 'Status'],
                    ['label' => 'Tanggal'],
                ]">
                    @forelse($transaksiTerbaru as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-medium">{{ $t->user->name ?? '-' }}</td>
                            <td>{{ $t->barang->nama ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $t->status === 'dipinjam' ? 'badge-warning' : 'badge-success' }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                            <td>{{ $t->tgl_pinjam ? \Carbon\Carbon::parse($t->tgl_pinjam)->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada transaksi terbaru</td>
                        </tr>
                    @endforelse
                </x-data-table>
            </x-card>

            <!-- Stok Menipis dengan Card & DataTable Component -->
            <x-card header="Stok Menipis (< 5 unit)" icon="fas fa-triangle-exclamation" icon-bg="#fef2f2" icon-color="#dc2626">
                <x-data-table :headers="[
                    ['label' => '#', 'width' => '50px'],
                    ['label' => 'Barang'],
                    ['label' => 'Kategori'],
                    ['label' => 'Stok', 'class' => 'text-center'],
                ]">
                    @forelse($barangStokMenipis as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-medium">{{ $b->nama }}</td>
                            <td>{{ $b->kategori->nama ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge badge-danger">{{ $b->jumlah }} unit</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">Semua stok barang masih aman</td>
                        </tr>
                    @endforelse
                </x-data-table>
            </x-card>
        </div>

        <!-- Aksi Cepat -->
        <x-card header="Aksi Cepat" icon="fas fa-bolt" icon-bg="#fdf4ff" icon-color="#a855f7">
            <div class="flex flex-wrap gap-3">
                <button type="button" class="btn btn-primary" style="background: #4f46e5;">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
                <button type="button" class="btn btn-primary" style="background: #059669;">
                    <i class="fas fa-tags"></i> Tambah Kategori
                </button>
                <button type="button" class="btn btn-primary" style="background: #e11d48;">
                    <i class="fas fa-hand-holding"></i> Pinjam Barang
                </button>
                <button type="button" class="btn btn-primary" style="background: #0284c7;">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>
        </x-card>

    @else
        <!-- Dashboard untuk Role Staff -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
            <p class="text-sm text-gray-500">Kelola peminjaman inventaris barang universitas Anda</p>
        </div>

        <x-card header="Peminjaman Saya" icon="fas fa-clock-rotate-left" icon-bg="#eff6ff" icon-color="#2563eb">
            <x-data-table :headers="[
                ['label' => '#', 'width' => '50px'],
                ['label' => 'Barang'],
                ['label' => 'Jumlah', 'class' => 'text-center'],
                ['label' => 'Tgl Pinjam'],
                ['label' => 'Status'],
            ]">
                @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="font-medium">{{ $t->barang->nama ?? '-' }}</td>
                        <td class="text-center">{{ $t->jumlah }}</td>
                        <td>{{ $t->tgl_pinjam ? \Carbon\Carbon::parse($t->tgl_pinjam)->format('d/m/Y') : '-' }}</td>
                        <td>
                            <span class="badge {{ $t->status === 'dipinjam' ? 'badge-warning' : 'badge-success' }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Anda belum memiliki riwayat peminjaman</td>
                    </tr>
                @endforelse
            </x-data-table>
        </x-card>
    @endif
</x-app-layout>
