<x-app-layout>
    <!-- Flash Messages -->
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

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Barang</h2>
            <p class="text-sm text-gray-500">Kelola master inventaris barang dan relasi kategori</p>
        </div>
        <a href="{{ route('barang.create') }}" class="btn btn-primary" style="background: #4f46e5;">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
    </div>

    <!-- Filter Card (Acara 15) -->
    <x-card class="mb-6">
        <form action="{{ route('barang.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="form-label text-xs uppercase font-semibold text-gray-500">Kategori</label>
                <div class="input-group">
                    <span class="icon"><i class="fas fa-tags"></i></span>
                    <select name="kategori_id" class="form-control text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label text-xs uppercase font-semibold text-gray-500">Kondisi</label>
                <div class="input-group">
                    <span class="icon"><i class="fas fa-filter"></i></span>
                    <select name="kondisi" class="form-control text-sm">
                        <option value="">Semua Kondisi</option>
                        <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ request('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ request('kondisi') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label text-xs uppercase font-semibold text-gray-500">Cari Barang</label>
                <div class="input-group">
                    <span class="icon"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama / deskripsi..." class="form-control text-sm">
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn btn-primary py-2 px-4 text-sm w-full justify-center" style="background: #4f46e5;">
                    <i class="fas fa-search"></i> Filter
                </button>
                @if(request()->hasAny(['kategori_id', 'kondisi', 'search']))
                    <a href="{{ route('barang.index') }}" class="btn btn-outline py-2 px-3 text-sm" title="Reset Filter">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Tabel Data Barang dengan Komponen Blade (Acara 12, 15, 16) -->
    <x-data-table :headers="[
        ['label' => 'No', 'width' => '50px', 'class' => 'text-center'],
        ['label' => 'Foto', 'width' => '70px', 'class' => 'text-center'],
        ['label' => 'Nama Barang'],
        ['label' => 'Kategori'],
        ['label' => 'Stok', 'class' => 'text-center', 'width' => '90px'],
        ['label' => 'Kondisi', 'class' => 'text-center', 'width' => '100px'],
        ['label' => 'Aksi', 'class' => 'text-right', 'width' => '190px'],
    ]" :paginator="$barangs">
        @forelse($barangs as $b)
            <tr>
                <td class="text-center font-medium text-gray-500">{{ $loop->iteration }}</td>
                <td class="text-center">
                    <!-- Thumbnail Foto Barang (Acara 16) -->
                    @if($b->gambar)
                        <img src="{{ asset($b->gambar) }}" alt="{{ $b->nama }}" class="w-10 h-10 rounded-lg object-cover mx-auto border border-gray-200 shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center mx-auto border border-dashed border-gray-300">
                            <i class="fas fa-cube text-xs"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <div class="font-semibold text-gray-800">{{ $b->nama }}</div>
                    @if($b->deskripsi)
                        <div class="text-xs text-gray-400 truncate max-w-xs">{{ $b->deskripsi }}</div>
                    @endif
                </td>
                <td>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-150">
                        <i class="fas fa-tag text-[10px]"></i>
                        {{ $b->kategori->nama ?? '-' }}
                    </span>
                </td>
                <td class="text-center font-bold {{ $b->jumlah < 5 ? 'text-rose-600' : 'text-slate-700' }}">
                    {{ $b->jumlah }}
                </td>
                <td class="text-center">
                    <span class="badge {{ $b->kondisi === 'baik' ? 'badge-success' : ($b->kondisi === 'rusak' ? 'badge-warning' : 'badge-danger') }}">
                        {{ ucfirst($b->kondisi) }}
                    </span>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <!-- Detail (Acara 15 & 16) -->
                        <a href="{{ route('barang.show', $b) }}" class="btn btn-outline py-1 px-2 text-xs text-blue-600 hover:text-blue-700" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit (Acara 15 & 16) -->
                        <a href="{{ route('barang.edit', $b) }}" class="btn btn-outline py-1 px-2 text-xs text-amber-600 hover:text-amber-700" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Delete (Acara 15) -->
                        <form action="{{ route('barang.destroy', $b) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus barang {{ $b->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline py-1 px-2 text-xs text-rose-600 hover:text-rose-700" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-10 text-gray-400">
                    <i class="fas fa-boxes-stacked text-3xl mb-2 block"></i>
                    Belum ada data barang inventaris
                </td>
            </tr>
        @endforelse
    </x-data-table>
</x-app-layout>
