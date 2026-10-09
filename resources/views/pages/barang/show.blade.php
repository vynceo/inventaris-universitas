<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('barang.index') }}" class="btn btn-outline py-2 px-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Detail Barang: {{ $barang->nama }}</h2>
                <p class="text-sm text-gray-500">Informasi spesifikasi lengkap dan riwayat peminjaman</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('barang.edit', $barang) }}" class="btn btn-primary" style="background: #d97706;">
                <i class="fas fa-edit"></i> Edit Barang
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Foto Barang (Acara 16) -->
        <x-card header="Foto Barang" icon="fas fa-image" icon-bg="#eff6ff" icon-color="#2563eb">
            <div class="flex flex-col items-center justify-center p-4">
                @if($barang->gambar)
                    <img src="{{ asset($barang->gambar) }}" alt="{{ $barang->nama }}" class="w-full max-w-[280px] h-64 object-cover rounded-xl border border-gray-200 shadow-md">
                @else
                    <div class="w-full h-56 rounded-xl bg-slate-100 border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400">
                        <i class="fas fa-cube text-4xl mb-2"></i>
                        <span class="text-sm">Tidak ada gambar</span>
                    </div>
                @endif
            </div>
        </x-card>

        <!-- Informasi Utama Barang (Acara 15) -->
        <x-card header="Informasi Inventaris" icon="fas fa-circle-info" icon-bg="#f0fdf4" icon-color="#16a34a" class="lg:col-span-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-3 bg-slate-50 rounded-lg">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Kategori</span>
                    <span class="inline-flex items-center gap-1.5 font-bold text-gray-800 mt-1">
                        <i class="fas fa-tag text-indigo-500"></i>
                        {{ $barang->kategori->nama ?? '-' }}
                    </span>
                </div>

                <div class="p-3 bg-slate-50 rounded-lg">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Jumlah Stok</span>
                    <span class="text-lg font-bold text-gray-800 mt-1 block">{{ $barang->jumlah }} unit</span>
                </div>

                <div class="p-3 bg-slate-50 rounded-lg">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Kondisi</span>
                    <span class="badge {{ $barang->kondisi === 'baik' ? 'badge-success' : ($barang->kondisi === 'rusak' ? 'badge-warning' : 'badge-danger') }} mt-1">
                        {{ ucfirst($barang->kondisi) }}
                    </span>
                </div>

                <div class="p-3 bg-slate-50 rounded-lg">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Terakhir Diperbarui</span>
                    <span class="text-sm font-medium text-gray-700 mt-1 block">
                        {{ $barang->updated_at ? $barang->updated_at->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block mb-1">Deskripsi</span>
                <p class="text-sm text-gray-700 leading-relaxed bg-white p-3 rounded-lg border border-gray-100">
                    {{ $barang->deskripsi ?? 'Tidak ada keterangan deskripsi tambahan.' }}
                </p>
            </div>
        </x-card>
    </div>

    <!-- Riwayat Peminjaman Barang -->
    <x-card header="Riwayat Peminjaman Barang Ini" icon="fas fa-clock-rotate-left" icon-bg="#fef3c7" icon-color="#d97706">
        <x-data-table :headers="[
            ['label' => '#', 'width' => '50px'],
            ['label' => 'Peminjam'],
            ['label' => 'Jumlah', 'class' => 'text-center'],
            ['label' => 'Tgl Pinjam'],
            ['label' => 'Tgl Kembali'],
            ['label' => 'Status'],
        ]">
            @forelse($barang->transaksis as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="font-medium">{{ $t->user->name ?? '-' }}</td>
                    <td class="text-center">{{ $t->jumlah }}</td>
                    <td>{{ $t->tgl_pinjam ? \Carbon\Carbon::parse($t->tgl_pinjam)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $t->tgl_kembali ? \Carbon\Carbon::parse($t->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="badge {{ $t->status === 'dipinjam' ? 'badge-warning' : 'badge-success' }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">Belum ada riwayat peminjaman untuk barang ini</td>
                </tr>
            @endforelse
        </x-data-table>
    </x-card>
</x-app-layout>
