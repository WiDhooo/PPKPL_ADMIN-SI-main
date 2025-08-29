<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $judul
 * @property string $deskripsi
 * @property string $tanggal
 * @property string|null $gambar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGaleri {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $nip
 * @property string $jabatan
 * @property string $mata_pelajaran
 * @property int $pengalaman
 * @property string|null $gambar
 * @property string $pendidikan_terakhir
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereMataPelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru wherePendidikanTerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru wherePengalaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guru whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGuru {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

