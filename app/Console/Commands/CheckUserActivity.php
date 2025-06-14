<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckUserActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:check-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user activity and mark inactive if no activity in last 3 months';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $users = User::all();

        foreach ($users as $user) {
            $hasBooking = $user->bookings()
                ->where('booking_date', '>=', $threeMonthsAgo)
                ->exists();

            $hasTransaction = $user->transactions()
                ->where('transaction_date', '>=', $threeMonthsAgo)
                ->exists();

            $hasTrainerBooking = $user->trainerBookings()
                ->where('booking_date', '>=', $threeMonthsAgo)
                ->exists();

            if (!$hasBooking && !$hasTransaction && !$hasTrainerBooking) {
                if ($user->status !== 'inactive') {
                    $user->status = 'inactive';
                    $user->save();
                    $this->info("User ID {$user->id} marked as inactive.");
                }
            } else {
                if ($user->status !== 'active') {
                    $user->status = 'active';
                    $user->save();
                    $this->info("User ID {$user->id} marked as active.");
                }
            }
        }

        return 0;
    }
}
