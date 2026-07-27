<?php

declare(strict_types=1);

namespace VioletSun\MAX\Console\Commands\Max;

use App\Models\Max\MaxMessageQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MaxMessageQueueHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'max:message-queue:handle {--limit=30 : Message queue handling limit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MAX, message queue handle';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $processedMessagesCount = 0;
        $limit = (int)($this->option('limit') ?? 10);

        MaxMessageQueue::query()
            ->limit($limit)
            ->get()
            ->each(function (MaxMessageQueue $queueMessage) use (&$processedMessagesCount) {
                try {
                    $queueMessage?->sendQueuedMessage();
                    $queueMessage?->delete();

                    $processedMessagesCount++;
                } catch (\Throwable $exception) {
                    Log::error('MAX message queue sending failed', [
                        'queue_message_id' => $queueMessage?->id,
                        'chat_id' => $queueMessage?->chat_id,
                        'exception' => $exception,
                    ]);
                }
            });
        $this->info("Processed messages: {$processedMessagesCount}");

        return self::SUCCESS;
    }
}
