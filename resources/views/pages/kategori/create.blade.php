<x-app-layout>
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('kategori.index') }}" class="btn btn-outline py-2 px-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Tambah Kategori</h2>
            <p class="text-sm text-gray-500">Buat kategori barang baru</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <x-card>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <x-form-input 
                    name="nama" 
                    label="Nama Kategori" 
                    icon="fas fa-tag" 
                    placeholder="Masukkan nama kategori" 
                    :required="true" 
                    :value="old('nama')" />

                <x-form-input 
                    name="deskripsi" 
                    label="Deskripsi" 
                    type="textarea" 
                    icon="fas fa-align-left" 
                    placeholder="Deskripsi kategori (opsional)" 
                    :rows="4" 
                    :value="old('deskripsi')" />

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn btn-primary" style="background: #4f46e5;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline">
                        Batal
                    </a>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
