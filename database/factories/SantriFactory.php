<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Santri;

class SantriFactory extends Factory
{
    protected $model = Santri::class;

    public function definition()
    {
        $gender = $this->faker->randomElement(['L', 'P']);
        $age = $this->faker->numberBetween(5, 12);
        $birthDate = Carbon::now()->subYears($age)->subDays(rand(0, 365));

        $tahunMasuk = Carbon::now()->format('y'); // last two digits of year
        $tanggalLahirFormatted = $birthDate->format('ymd');
        $randomThreeDigits = $this->faker->numerify('###');

        $nis = $tahunMasuk . $tanggalLahirFormatted . $randomThreeDigits;

        return [
            'nis' => $nis,
            'nama_santri' => $this->faker->name($gender == 'L' ? 'male' : 'female'),
            'jenis_kelamin' => $gender,
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $birthDate->format('Y-m-d'),
            'nama_orang_tua' => $this->faker->name(),
            'no_hp' => substr($this->faker->phoneNumber(), 0, 15),
            'alamat' => $this->faker->address(),
            'akta_kelahiran' => $this->faker->lexify('akta_??????.pdf'),
            'kartu_keluarga' => $this->faker->lexify('kk_??????.pdf'),
        ];
    }
}
