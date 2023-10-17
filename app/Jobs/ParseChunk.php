<?php

namespace App\Jobs;

use App\Models\Row;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ParseChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $rows;
    private string $uid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $rows, string $uid)
    {
        $this->rows = $rows;
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            Row::insert($this->rows);

            Redis::incrby($this->uid, count($this->rows));

            echo "Inserted " . count($this->rows) . " rows [{$this->uid}]" . PHP_EOL;

            /* FAKE TIMEOUT */
            sleep(2);
            /* FAKE TIMEOUT */

            return Command::SUCCESS;
        } catch (Exception $exception) {
            echo "Error happened: " . $exception->getMessage() . PHP_EOL;

            return Command::FAILURE;
        }
    }
}
