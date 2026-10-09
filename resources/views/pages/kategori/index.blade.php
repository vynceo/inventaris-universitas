<x-app-layout>
    <!-- FLASH MESSAGES (Acara 14) -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kategori</h2>
            <p class="text-sm text-gray-500">Kelola data kategori barang</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary" style="background: #4f46e5;">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <!-- Data Table Menggunakan Komponen Blade (Acara 12 & 13) -->
    <x-data-table :headers="[
        ['label' => 'No', 'width' => '60px', 'class' => 'text-center'],
        ['label' => 'Nama Kategori'],
        ['label' => 'Deskripsi'],
        ['label' => 'Jml Barang', 'class' => 'text-center', 'width' => '120px'],
        ['label' => 'Aksi', 'class' => 'text-right', 'width' => '160px'],
    ]">
        @forelse($kategoris as $ket)
            <tr>
                <td class="text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                <td class="font-semibold text-gray-800">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-tag text-indigo-500"></i>
                        <span>{{ $ket->nama }}</span>
                    </div>
                </td>
                <td class="text-gray-600">{{ $ket->deskripsi ?? '-' }}</td>
                <td class="text-center">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ket->barangs_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                        {{ $ket->barangs_count }} barang
                    </span>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        <!-- Tombol Edit (Acara 14) -->
                        <a href="{{ route('kategori.edit', $ket) }}" class="btn btn-outline py-1 px-2.5 text-xs text-amber-600 hover:text-amber-700">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Tombol Delete dengan Konfirmasi JS (Acara 14) -->
                        <form action="{{ route('kategori.destroy', $ket) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori {{ $ket->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline py-1 px-2.5 text-xs text-rose-600 hover:text-rose-700">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">
                    <i class="fas fa-tags text-3xl mb-2 block"></i>
                    Belum ada data kategori
                </td>
            </tr>
        @endforelse
    </x-data-table>
</x-app-layout>
