<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found to create document records!');
            return;
        }

        $documentTypes = [
            'Resume',
            'Contract',
            'ID Card',
            'Passport',
            'Visa',
            'Work Permit',
            'Certificate',
            'Diploma',
            'Performance Review',
            'Recommendation Letter'
        ];

        // Create 2-5 documents for each user
        foreach ($users as $user) {
            $numDocuments = rand(2, 5);

            // Shuffle document types to avoid duplicates for the same user
            shuffle($documentTypes);

            for ($i = 0; $i < $numDocuments; $i++) {
                $documentType = $documentTypes[$i];
                $fileName = Str::slug($user->name) . '-' . Str::slug($documentType) . '.pdf';

                // Create a fake file path (in a real app, this would be the actual storage path)
                $filePath = 'documents/' . $user->id . '/' . $fileName;

                Document::create([
                    'user_id' => $user->id,
                    'document_type' => $documentType,
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]);
            }
        }

        $this->command->info('Document records seeded successfully!');
    }
}
