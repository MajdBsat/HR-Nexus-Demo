<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get all jobs and users
        $jobs = Job::all();
        $users = User::all();

        if ($jobs->isEmpty()) {
            $this->command->warn('No jobs found! Please run JobSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('No users found! Please create some users first.');
            return;
        }

        $this->command->info('Seeding job applications...');

        // Clear existing data to avoid unique constraint violations
        DB::table('job_applications')->truncate();

        // Define possible statuses and sources
        $statuses = ['Applied', 'Shortlisted', 'Interviewing', 'Offered', 'Hired', 'Rejected'];
        $sources = ['Company Website', 'LinkedIn', 'Indeed', 'Glassdoor', 'Referral'];

        // Track already used user-job combinations to avoid duplicates
        $usedCombinations = [];

        // Generate between 1-3 applications for each job
        foreach ($jobs as $job) {
            $applicationsCount = min(mt_rand(1, 3), count($users));
            $jobApplicants = $users->shuffle()->take($applicationsCount);

            foreach ($jobApplicants as $applicant) {
                // Check if this combination already exists
                $key = $job->id . '-' . $applicant->id;
                if (in_array($key, $usedCombinations)) {
                    continue;
                }

                // Add to used combinations
                $usedCombinations[] = $key;

                // Randomize the application date (within the last 30 days)
                $appliedDate = now()->subDays(mt_rand(1, 30));

                // Set random status
                $status = $statuses[array_rand($statuses)];

                // Generate random resume and cover letter content
                $resumeContent = $this->generateResumeContent($applicant);
                $coverLetterContent = $this->generateCoverLetterContent($applicant, $job);

                // Create the job application data according to our schema
                $jobApplicationData = [
                    'job_id' => $job->id,
                    'user_id' => $applicant->id,
                    'application_date' => $appliedDate,
                    'status' => $status,
                    'cover_letter' => $coverLetterContent,
                    'resume_path' => null, // We're storing the actual content in additional_info
                    'additional_info' => json_encode(['resume_content' => $resumeContent]),
                    'education' => json_encode($this->generateEducation()),
                    'experience' => json_encode($this->generateExperience()),
                    'skills' => json_encode($this->generateSkills()),
                    'references' => json_encode($this->generateReferences()),
                    'interview_notes' => $status === 'Interviewing' ? json_encode(['notes' => 'Candidate performed well in the interview.']) : null,
                    'assessments' => null,
                    'metadata' => json_encode([
                        'ip_address' => $this->generateRandomIP(),
                        'source' => $sources[array_rand($sources)],
                        'device_type' => ['Desktop', 'Mobile', 'Tablet'][array_rand(['Desktop', 'Mobile', 'Tablet'])],
                        'application_completed_in_minutes' => mt_rand(5, 60)
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Save the job application
                JobApplication::create($jobApplicationData);
            }
        }

        $this->command->info('Job applications seeded successfully!');
    }

    /**
     * Generate education data
     */
    private function generateEducation(): array
    {
        return [
            [
                'institution' => 'University of Technology',
                'degree' => 'Bachelor of Science',
                'field' => 'Computer Science',
                'start_date' => '2015-09-01',
                'end_date' => '2019-05-31',
                'gpa' => mt_rand(30, 40) / 10
            ]
        ];
    }

    /**
     * Generate experience data
     */
    private function generateExperience(): array
    {
        return [
            [
                'company' => 'Tech Solutions Inc.',
                'position' => 'Software Developer',
                'start_date' => '2019-06-01',
                'end_date' => null,
                'current' => true,
                'description' => 'Developing web applications using modern frameworks.'
            ],
            [
                'company' => 'Digital Innovations',
                'position' => 'Junior Developer',
                'start_date' => '2017-05-01',
                'end_date' => '2019-05-31',
                'current' => false,
                'description' => 'Assisted in development of client websites and applications.'
            ]
        ];
    }

    /**
     * Generate skills data
     */
    private function generateSkills(): array
    {
        $allSkills = [
            'PHP', 'JavaScript', 'HTML', 'CSS', 'React', 'Vue', 'Angular', 'Node.js', 'Python',
            'Java', 'C#', 'SQL', 'NoSQL', 'MongoDB', 'MySQL', 'Git', 'Docker', 'AWS',
            'Azure', 'Agile', 'Scrum', 'Communication', 'Problem Solving'
        ];

        $numSkills = mt_rand(5, 10);
        $selectedSkillKeys = array_rand($allSkills, $numSkills);

        if (!is_array($selectedSkillKeys)) {
            $selectedSkillKeys = [$selectedSkillKeys];
        }

        $skills = [];
        foreach ($selectedSkillKeys as $key) {
            $skills[] = [
                'name' => $allSkills[$key],
                'level' => ['Beginner', 'Intermediate', 'Advanced', 'Expert'][array_rand(['Beginner', 'Intermediate', 'Advanced', 'Expert'])]
            ];
        }

        return $skills;
    }

    /**
     * Generate references data
     */
    private function generateReferences(): array
    {
        return [
            [
                'name' => 'John Smith',
                'position' => 'Senior Developer',
                'company' => 'Tech Solutions Inc.',
                'email' => 'john.smith@example.com',
                'phone' => '(555) ' . mt_rand(100, 999) . '-' . mt_rand(1000, 9999),
                'relationship' => 'Former Manager'
            ]
        ];
    }

    /**
     * Generate random IP address
     */
    private function generateRandomIP(): string
    {
        return mt_rand(1, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
    }

    /**
     * Generate a random resume content for an applicant
     */
    private function generateResumeContent(User $user): string
    {
        $skills = [
            'PHP', 'JavaScript', 'HTML', 'CSS', 'React', 'Vue', 'Angular', 'Node.js', 'Python',
            'Java', 'C#', 'C++', 'Ruby', 'Swift', 'TypeScript', 'SQL', 'NoSQL', 'MongoDB',
            'MySQL', 'Redis', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP', 'Git', 'CI/CD',
            'Agile', 'Scrum', 'Project Management', 'Team Leadership', 'Problem Solving',
            'Critical Thinking', 'Communication', 'Time Management', 'Customer Service'
        ];

        // Fix: Select random skills properly
        $numSkills = mt_rand(5, 10);
        $selectedSkillKeys = array_rand($skills, $numSkills);

        // If only one skill is selected, make sure it's in an array
        if (!is_array($selectedSkillKeys)) {
            $selectedSkillKeys = [$selectedSkillKeys];
        }

        $selectedSkills = [];
        foreach ($selectedSkillKeys as $key) {
            $selectedSkills[] = $skills[$key];
        }

        $skillsText = implode(', ', $selectedSkills);

        // Create a basic resume format
        $resume = "# {$user->name}\n";
        $resume .= "Email: {$user->email} | Phone: (555) " . mt_rand(100, 999) . "-" . mt_rand(1000, 9999) . "\n\n";
        $resume .= "## Professional Summary\n";
        $resume .= "Experienced professional with " . mt_rand(2, 8) . "+ years of experience in the technology industry. ";
        $resume .= "Skilled in $skillsText. ";
        $resume .= "Passionate about delivering high-quality solutions and driving innovation.\n\n";
        $resume .= "## Skills\n$skillsText\n\n";
        $resume .= "## Work Experience\n\n";

        // Add sample work experience
        $resume .= "### Web Developer\n";
        $resume .= "Digital Dynamics | 2022 - Present\n";
        $resume .= "- Deployed and maintained applications in cloud environments\n";
        $resume .= "- Managed and improved existing codebase, fixing bugs and adding features\n";
        $resume .= "- Implemented security and data protection measures\n\n";

        $resume .= "### DevOps Engineer\n";
        $resume .= "TechCorp Inc. | 2020 - 2022\n";
        $resume .= "- Researched and implemented new technologies to improve development efficiency\n";
        $resume .= "- Mentored junior developers and provided technical guidance\n";
        $resume .= "- Managed database schema design and optimization\n\n";

        $resume .= "## Education\n\n";
        $resume .= "### Associate Degree in Web Development\n";
        $resume .= "Liberal Arts College | " . (now()->year - mt_rand(5, 15)) . " - " . (now()->year - mt_rand(1, 4)) . "\n";

        return $resume;
    }

    /**
     * Generate a random cover letter content
     */
    private function generateCoverLetterContent(User $user, Job $job): string
    {
        $coverLetter = "Dear Hiring Manager,\n\n";
        $coverLetter .= "I am writing to express my interest in the {$job->title} position at {$job->department}. ";
        $coverLetter .= "With my background and skills, I believe I am well-qualified for this role.\n\n";

        $achievement = "increased application performance by optimizing code and database queries";
        $coverLetter .= "Throughout my career, I have $achievement. I am particularly drawn to {$job->department} because of its reputation for adapting quickly to industry changes.\n\n";

        $contribution = "mentored junior developers and helped build strong technical teams";
        $coverLetter .= "In my previous roles, I have $contribution and streamlined development processes that saved time and resources. ";
        $coverLetter .= "These experiences have prepared me well for the challenges of the {$job->title} position.\n\n";

        $coverLetter .= "I am excited about the opportunity to bring my unique skills to {$job->department} and contribute to your team. ";
        $coverLetter .= "Thank you for considering my application. I look forward to the possibility of discussing how I can contribute to your organization.\n\n";

        $coverLetter .= "Sincerely,\n{$user->name}";

        return $coverLetter;
    }
}
