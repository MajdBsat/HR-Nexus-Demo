<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $users = User::all();

        if ($jobs->isEmpty()) {
            $this->command->info('No jobs found to create candidate records!');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->info('No users found to create candidate records!');
            return;
        }

        $statuses = [
            'Applied',
            'Screening',
            'Interview Scheduled',
            'Technical Assessment',
            'HR Interview',
            'Offer Extended',
            'Hired',
            'Rejected',
            'Withdrawn'
        ];

        // Create 1-3 candidates for each job
        foreach ($jobs as $job) {
            $numCandidates = rand(1, 3);

            for ($i = 0; $i < $numCandidates; $i++) {
                // Randomly select a user
                $user = $users->random();

                // Randomly select a status
                $status = $statuses[array_rand($statuses)];

                Candidate::create([
                    'job_id' => $job->id,
                    'user_id' => $user->id,
                    'status' => $status
                ]);
            }
        }

        $this->command->info('Candidate records seeded successfully!');
    }
}
