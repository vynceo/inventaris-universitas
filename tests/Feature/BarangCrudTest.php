<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BarangCrudTest extends TestCase
{
    use RefreshDatabase;

    private function getUser()
    {
        return User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    }

    private function getKategori()
    {
        return Kategori::first() ?? Kategori::create(['nama' => 'Elektronik Test', 'deskripsi' => 'Deskripsi']);
    }

    public function test_barang_index_can_be_rendered(): void
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->get(route('barang.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Barang');
    }

    public function test_barang_create_page_can_be_rendered(): void
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->get(route('barang.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Barang');
    }

    public function test_barang_can_be_stored_with_image(): void
    {
        Storage::fake('public');
        $user = $this->getUser();
        $kategori = $this->getKategori();

        $image = UploadedFile::fake()->image('laptop_asus.jpg', 600, 400);

        $response = $this->actingAs($user)->post(route('barang.store'), [
            'kategori_id' => $kategori->id,
            'nama'        => 'Asus ROG Gaming',
            'jumlah'      => 7,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Laptop spesifikasi gaming',
            'gambar'      => $image,
        ]);

        $response->assertRedirect(route('barang.index'));
        $response->assertSessionHas('success');

        $barang = Barang::where('nama', 'Asus ROG Gaming')->first();
        $this->assertNotNull($barang);
        $this->assertNotNull($barang->gambar);
    }

    public function test_barang_show_page_can_be_rendered(): void
    {
        $user = $this->getUser();
        $barang = Barang::first() ?? Barang::create([
            'kategori_id' => $this->getKategori()->id,
            'nama'        => 'Item Detail Test',
            'jumlah'      => 10,
            'kondisi'     => 'baik',
        ]);

        $response = $this->actingAs($user)->get(route('barang.show', $barang));
        $response->assertStatus(200);
        $response->assertSee($barang->nama);
    }

    public function test_barang_edit_page_can_be_rendered(): void
    {
        $user = $this->getUser();
        $barang = Barang::first() ?? Barang::create([
            'kategori_id' => $this->getKategori()->id,
            'nama'        => 'Item Edit Test',
            'jumlah'      => 10,
            'kondisi'     => 'baik',
        ]);

        $response = $this->actingAs($user)->get(route('barang.edit', $barang));
        $response->assertStatus(200);
        $response->assertSee('Edit Barang');
    }

    public function test_barang_can_be_updated_with_new_image(): void
    {
        Storage::fake('public');
        $user = $this->getUser();
        $kategori = $this->getKategori();

        $barang = Barang::create([
            'kategori_id' => $kategori->id,
            'nama'        => 'Monitor LG 24 Inch',
            'jumlah'      => 8,
            'kondisi'     => 'baik',
        ]);

        $newImage = UploadedFile::fake()->image('monitor_lg.png', 500, 500);

        $response = $this->actingAs($user)->put(route('barang.update', $barang), [
            'kategori_id' => $kategori->id,
            'nama'        => 'Monitor LG 24 Inch UltraWide',
            'jumlah'      => 10,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Resolusi Full HD IPS',
            'gambar'      => $newImage,
        ]);

        $response->assertRedirect(route('barang.index'));
        $response->assertSessionHas('success');

        $barang->refresh();
        $this->assertEquals('Monitor LG 24 Inch UltraWide', $barang->nama);
        $this->assertNotNull($barang->gambar);
    }

    public function test_barang_cannot_be_deleted_if_currently_borrowed(): void
    {
        $user = $this->getUser();
        $barang = Barang::create([
            'kategori_id' => $this->getKategori()->id,
            'nama'        => 'Kamera DSLR Canon',
            'jumlah'      => 3,
            'kondisi'     => 'baik',
        ]);

        Transaksi::create([
            'user_id'    => $user->id,
            'barang_id'  => $barang->id,
            'jumlah'     => 1,
            'tgl_pinjam' => now(),
            'status'     => 'dipinjam',
        ]);

        $response = $this->actingAs($user)->delete(route('barang.destroy', $barang));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('barangs', ['id' => $barang->id]);
    }

    public function test_barang_can_be_deleted_if_not_borrowed(): void
    {
        $user = $this->getUser();
        $barang = Barang::create([
            'kategori_id' => $this->getKategori()->id,
            'nama'        => 'Tripod Kamera',
            'jumlah'      => 2,
            'kondisi'     => 'rusak',
        ]);

        $response = $this->actingAs($user)->delete(route('barang.destroy', $barang));

        $response->assertRedirect(route('barang.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('barangs', ['id' => $barang->id]);
    }
}
