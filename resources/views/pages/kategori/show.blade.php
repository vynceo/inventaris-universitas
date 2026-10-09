<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('kategori.index') }}" class="btn btn-outline py-2 px-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Detail Kategori: {{ $kategori->nama }}</h2>
                <p class="text-sm text-gray-500">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>
        <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-primary" style="background: #d97706;">
            <i class="fas fa-edit"></i> Edit Kategori
        </a>
    </div>

    <x-card header="Daftar Barang dalam Kategori Ini" icon="fas fa-boxes-stacked" icon-bg="#e0f2fe" icon-color="#0284c7">
        <x-data-table :headers="[
            ['label' => '#', 'width' => '50px'],
            ['label' => 'Nama Barang'],
            ['label' => 'Stok', 'class' => 'text-center'],
            ['label' => 'Kondisi'],
        ]">
            @forelse($kategori->barangs as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="font-medium">{{ $b->nama }}</td>
                    <td class="text-center font-semibold">{{ $b->jumlah }} unit</td>
                    <td>
                        <span class="badge {{ $b->kondisi === 'baik' ? 'badge-success' : ($b->kondisi === 'rusak' ? 'badge-warning' : 'badge-danger') }}">
                            {{ ucfirst($b->kondisi) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">Belum ada barang di kategori ini</td>
                </tr>
            @endforelse
        </x-data-table>
    </x-card>
</x-app-layout>
