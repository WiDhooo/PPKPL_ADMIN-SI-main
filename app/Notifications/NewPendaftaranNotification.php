<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Pendaftaran;

class NewPendaftaranNotification extends Notification
{
    use Queueable;

    protected $pendaftaran;

    /**
     * Create a new notification instance.
     *
     * @param Pendaftaran $pendaftaran
     * @return void
     */
    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'pendaftaran_id' => $this->pendaftaran->id,
            'nama_santri' => $this->pendaftaran->nama_santri,
            'message' => "Pendaftaran baru dari {$this->pendaftaran->nama_santri} telah masuk.",
        ];
    }
}
