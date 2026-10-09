<x-app-layout>
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('barang.index') }}" class="btn btn-outline py-2 px-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Tambah Barang</h2>
            <p class="text-sm text-gray-500">Input inventaris barang baru ke dalam sistem</p>
        </div>
    </div>

    <div class="max-w-3xl">
        <x-card>
            <!-- Form Upload Berkas (Acara 16: enctype multipart/form-data) -->
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form-input 
                        name="nama" 
                        label="Nama Barang" 
                        icon="fas fa-box" 
                        placeholder="Contoh: Laptop HP Pavilion 14" 
                        :required="true" 
                        :value="old('nama')" />

                    <x-form-input 
                        name="kategori_id" 
                        label="Kategori" 
                        type="select" 
                        icon="fas fa-tags" 
                        :required="true">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </x-form-input>

                    <x-form-input 
                        name="jumlah" 
                        label="Jumlah Stok" 
                        type="number" 
                        icon="fas fa-hashtag" 
                        placeholder="Jumlah unit" 
                        :required="true" 
                        :value="old('jumlah', 1)" />

                    <x-form-input 
                        name="kondisi" 
                        label="Kondisi Barang" 
                        type="select" 
                        icon="fas fa-clipboard-check" 
                        :required="true">
                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ old('kondisi') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </x-form-input>
                </div>

                <x-form-input 
                    name="deskripsi" 
                    label="Deskripsi / Spesifikasi" 
                    type="textarea" 
                    icon="fas fa-align-left" 
                    placeholder="Tuliskan spesifikasi detail barang..." 
                    :rows="3" 
                    :value="old('deskripsi')" />

                <!-- Upload Gambar Barang (Acara 16) -->
                <div class="form-group mt-2">
                    <label class="form-label">
                        Foto Barang <span class="text-xs text-gray-400 font-normal">(Opsional - format: jpeg, png, jpg, gif, maks: 2MB)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-indigo-400 transition bg-slate-50">
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>
                    @error('gambar')
                        <p class="text-xs text-rose-600 mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn btn-primary" style="background: #4f46e5;">
                        <i class="fas fa-save"></i> Simpan Barang
                    </button>
                    <a href="{{ route('barang.index') }}" class="btn btn-outline">
                        Batal
                    </a>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
