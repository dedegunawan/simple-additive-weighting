<?php

namespace Database\Seeders;

use App\Models\Crips;
use App\Models\CripsDetail;
use App\Models\Kriteria;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::firstOrCreate([
			 'email' => 'gunawan@dede.web.id'
         ], [
			 'name' => 'Dede Gunawan',
	         'password' => password_hash('dedegunawan', PASSWORD_DEFAULT)
         ]);

		 $crips_prestasi = $this->setupCripsPrestasi();
		 $crips_penghasilan = $this->setupCripsPenghasilan();
		 $this->setupKriteria($crips_penghasilan, $crips_prestasi);

    }

	public function setupCripsPenghasilan() {

		$crips = Crips::firstOrCreate([
			'nama_crips' => 'Penghasilan Orang Tua'
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => '<= Rp. 1.000.000',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 1
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => 'Rp. 1.000.000 - Rp. 3.000.000',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 2
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => 'Rp. 3.000.000 - Rp. 5.000.000',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 3
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => '>= Rp. 5.000.000',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 4
		]);

		return $crips;

	}
	public function setupCripsPrestasi() {

		$crips = Crips::firstOrCreate([
			'nama_crips' => 'Prestasi'
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => 'Tingkat Kota/Kabupaten',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 1
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => 'Tingkat Provinsi',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 2
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => 'Tingkat Nasional',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 3
		]);

		CripsDetail::firstOrCreate([
			'deskripsi' => 'Tingkat Internasional',
		], [
			'crips_id' => $crips['id'],
			'kelompok' => 4
		]);

		return $crips;

	}

	public function setupKriteria($crips_penghasilan, $crips_prestasi) {
		Kriteria::firstOrCreate([
			'nama_kriteria' => 'IPK'
		], [
			'satuan' => '-',
			'bobot' => 25,
			'crips_id' => null,
			'tipe_data' => 'float',
		]);

		Kriteria::firstOrCreate([
			'nama_kriteria' => 'Penghasilan Ortu/bln'
		], [
			'satuan' => 'juta',
			'bobot' => 15,
			'crips_id' => $crips_penghasilan['id'],
			'tipe_data' => 'crips',
		]);

		Kriteria::firstOrCreate([
			'nama_kriteria' => 'Jumlah Tanggungan'
		], [
			'satuan' => 'orang',
			'bobot' => 20,
			'crips_id' => null,
			'tipe_data' => 'integer',
		]);

		Kriteria::firstOrCreate([
			'nama_kriteria' => 'Prestasi'
		], [
			'satuan' => '-',
			'bobot' => 30,
			'crips_id' => $crips_prestasi['id'],
			'tipe_data' => 'crips',
		]);

		Kriteria::firstOrCreate([
			'nama_kriteria' => 'Lokasi Rumah'
		], [
			'satuan' => 'km',
			'bobot' => 10,
			'crips_id' => null,
			'tipe_data' => 'integer',
		]);
	}
}
