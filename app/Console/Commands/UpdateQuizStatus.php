<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StudentActiveQuiz;

class UpdateQuizStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-quiz-status';

    /** $schedule->command('app:update-quiz-status')->daily();
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = now()->startOfDay();

        StudentActiveQuiz::where('end_date', '<', $now)
        ->update(['status' => 'lapse']);

        $this->info('Quiz status updated successfully!');
    }
}
