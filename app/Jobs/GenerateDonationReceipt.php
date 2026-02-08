<?php

namespace App\Jobs;

use App\Models\Donation;
use App\Models\DonationReceipt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateDonationReceipt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Donation $donation)
    {
    }

    public function handle(): void
    {
        // 1. Ensure receipt doesn't already exist
        if ($this->donation->receipt) {
            return;
        }

        $mosque = $this->donation->mosque;
        $receiptNumber = 'REC-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        $fileName = "receipts/{$mosque->slug}/{$receiptNumber}.pdf";

        // 2. Generate PDF using DomPDF
        $pdf = Pdf::loadView('receipts.donation_pdf', [
            'donation' => $this->donation
        ]);

        // 3. Store PDF
        Storage::disk('public')->put($fileName, $pdf->output());

        // 4. Record receipt in DB
        DonationReceipt::create([
            'mosque_id' => $this->donation->mosque_id,
            'donation_id' => $this->donation->id,
            'receipt_number' => $receiptNumber,
            'pdf_path' => $fileName,
            'issued_at' => now(),
        ]);
    }
}
