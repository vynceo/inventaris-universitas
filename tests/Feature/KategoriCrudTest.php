<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriCrudTest extends TestCase
{
    use RefreshDatabase;

    private function getUser()
    {
        return User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    }

    public function test_kategori_index_can_be_rendered(): void
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->get(route('kategori.index'));

        $response->assertStatus(200);
        $response->assertSee('Kategori');
    }

    public function test_kategori_create_page_can_be_rendered(): void
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->get(route('kategori.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Kategori');
    }

    public function test_kategori_can_be_stored(): void
    {
        $user = $this->getUser();
        $response = $this->actingAs($user)->post(route('kategori.store'), [
            'nama'      => 'Laboratorium Jaringan',
            'deskripsi' => 'Perangkat dan router lab',
        ]);

        $response->assertRedirect(route('kategori.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kategoris', ['nama' => 'Laboratorium Jaringan']);
    }

    public function test_kategori_edit_page_can_be_rendered(): void
    {
        $user = $this->getUser();
        $kategori = Kategori::first() ?? Kategori::create(['nama' => 'Elektronik', 'deskripsi' => 'Deskripsi']);

        $response = $this->actingAs($user)->get(route('kategori.edit', $kategori));
        $response->assertStatus(200);
        $response->assertSee('Edit Kategori');
    }

    public function test_kategori_can_be_updated(): void
    {
        $user = $this->getUser();
        $kategori = Kategori::first() ?? Kategori::create(['nama' => 'Elektronik', 'deskripsi' => 'Deskripsi']);

        $response = $this->actingAs($user)->put(route('kategori.update', $kategori), [
            'nama'      => 'Elektronik & Multimedia',
            'deskripsi' => 'Deskripsi baru yang diperbarui',
        ]);

        $response->assertRedirect(route('kategori.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kategoris', ['nama' => 'Elektronik & Multimedia']);
    }

    public function test_kategori_cannot_be_deleted_if_it_has_barang(): void
    {
        $user = $this->getUser();
        
        $kategoriWithBarang = Kategori::create([
            'nama'      => 'Kategori Dengan Barang',
            'deskripsi' => 'Kategori yang memiliki relasi barang',
        ]);

        Barang::create([
            'kategori_id' => $kategoriWithBarang->id,
            'nama'        => 'Item Uji Relasi',
            'jumlah'      => 5,
            'kondisi'     => 'baik',
        ]);

        $response = $this->actingAs($user)->delete(route('kategori.destroy', $kategoriWithBarang));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('kategoris', ['id' => $kategoriWithBarang->id]);
    }

    public function test_kategori_can_be_deleted_if_it_has_no_barang(): void
    {
        $user = $this->getUser();
        $kategoriEmpty = Kategori::create([
            'nama'      => 'Kategori Tanpa Barang',
            'deskripsi' => 'Kategori uji coba untuk dihapus',
        ]);

        $response = $this->actingAs($user)->delete(route('kategori.destroy', $kategoriEmpty));

        $response->assertRedirect(route('kategori.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('kategoris', ['id' => $kategoriEmpty->id]);
    }
}
