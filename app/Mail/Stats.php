<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Stats extends Mailable
{
    use Queueable, SerializesModels;

    public $artist_total, $playlist_total, $track_sum;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $artist_total, int $playlist_total, int $track_sum)
    {
        $this->artist_total = $artist_total;
        $this->playlist_total = $playlist_total;
        $this->track_sum = $track_sum;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("View your Music-App stats for this year!")
            ->view('email.stats');
    }
}
