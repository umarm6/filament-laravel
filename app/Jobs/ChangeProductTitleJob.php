<?php

namespace App\Jobs;

use App\Models\Products;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ChangeProductTitleJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $productId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = Products::findOrFail($this->productId);
        $name = $product->name;
        $product->update([
            'name' => sprintf("%s - updated from JOB",$name), // change field/value as needed
        ]);

    }
}
