<?php

namespace Database\Seeders;

use App\Models\Compliance;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found to create compliance records!');
            return;
        }

        $complianceRecords = [
            [
                'title' => 'Annual Ethics Training',
                'description' => 'Mandatory ethics training that must be completed annually by all employees.'
            ],
            [
                'title' => 'Data Protection Certification',
                'description' => 'Certification required for handling sensitive customer data according to GDPR regulations.'
            ],
            [
                'title' => 'Workplace Safety Training',
                'description' => 'Required training for workplace safety procedures and emergency protocols.'
            ],
            [
                'title' => 'Anti-Harassment Policy Acknowledgment',
                'description' => 'Acknowledgment of company anti-harassment policies and reporting procedures.'
            ],
            [
                'title' => 'Information Security Training',
                'description' => 'Training on proper handling of confidential information and cybersecurity best practices.'
            ],
            [
                'title' => 'Code of Conduct Acknowledgment',
                'description' => 'Annual acknowledgment of the company\'s code of conduct and ethical guidelines.'
            ],
            [
                'title' => 'Conflict of Interest Disclosure',
                'description' => 'Mandatory disclosure of any potential conflicts of interest with company business.'
            ],
        ];

        // Assign 2-4 random compliance records to each user
        foreach ($users as $user) {
            // Shuffle and select random compliance records
            shuffle($complianceRecords);
            $numRecords = rand(2, 4);

            for ($i = 0; $i < $numRecords; $i++) {
                Compliance::create([
                    'user_id' => $user->id,
                    'title' => $complianceRecords[$i]['title'],
                    'description' => $complianceRecords[$i]['description']
                ]);
            }
        }

        $this->command->info('Compliance records seeded successfully!');
    }
}
