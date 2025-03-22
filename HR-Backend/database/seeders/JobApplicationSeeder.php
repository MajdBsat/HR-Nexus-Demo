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
        // First, check if we have jobs and users
        $jobs = Job::all();
        if ($jobs->isEmpty()) {
            $this->command->info('No jobs found! Please run JobSeeder first.');
            return;
        }

        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->info('No users found! Please run UserSeeder first.');
            return;
        }

        // Clear existing data
        DB::table('job_applications')->truncate();

        $statuses = ['Submitted', 'Screening', 'Interview', 'Technical Assessment', 'Reference Check', 'Offered', 'Hired', 'Rejected', 'Withdrawn'];
        $sources = ['Company Website', 'LinkedIn', 'Indeed', 'Glassdoor', 'Referral', 'Job Fair', 'University', 'Direct Application'];

        // Generate between 3-10 applications for each job
        foreach ($jobs as $job) {
            $applicationsCount = mt_rand(3, 10);

            for ($i = 0; $i < $applicationsCount; $i++) {
                // Get a random user to represent the applicant
                $applicant = $users->random();

                // Randomize the application date (within the last 30 days)
                $appliedDate = now()->subDays(mt_rand(1, 30));

                // Set random status
                $status = $statuses[array_rand($statuses)];

                // Generate interview date if in interview status
                $interviewDate = null;
                if (in_array($status, ['Interview', 'Technical Assessment'])) {
                    $interviewDate = now()->addDays(mt_rand(1, 14));
                }

                // Generate random resume and cover letter content
                $resumeContent = $this->generateResumeContent($applicant);
                $coverLetterContent = $this->generateCoverLetterContent($applicant, $job);

                // Create job application entry
                JobApplication::create([
                    'job_id' => $job->id,
                    'user_id' => $applicant->id,
                    'applied_date' => $appliedDate,
                    'status' => $status,
                    'resume' => $resumeContent,
                    'cover_letter' => $coverLetterContent,
                    'source' => $sources[array_rand($sources)],
                    'interview_date' => $interviewDate,
                    'feedback' => $this->generateFeedback($status),
                    'notes' => $this->generateNotes($status),
                    'metadata' => json_encode([
                        'ip_address' => '192.168.' . mt_rand(1, 255) . '.' . mt_rand(1, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . mt_rand(80, 100) . '.0.' . mt_rand(1000, 5000) . '.' . mt_rand(10, 100) . ' Safari/537.36',
                        'device_type' => ['Desktop', 'Mobile', 'Tablet'][array_rand(['Desktop', 'Mobile', 'Tablet'])],
                        'application_completed_in_minutes' => mt_rand(5, 60)
                    ])
                ]);
            }
        }

        $this->command->info('Job applications seeded successfully!');
    }

    /**
     * Generate a random resume content for an applicant
     *
     * @param User $user
     * @return string
     */
    private function generateResumeContent(User $user): string
    {
        $skills = [
            'JavaScript', 'Python', 'Java', 'C#', 'PHP', 'Ruby', 'Swift', 'Go', 'Kotlin',
            'HTML/CSS', 'React', 'Angular', 'Vue.js', 'Node.js', 'Express', 'Django', 'Flask',
            'Spring Boot', 'Laravel', 'Ruby on Rails', 'ASP.NET', 'SQL', 'MongoDB', 'PostgreSQL',
            'MySQL', 'Redis', 'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP', 'Git', 'CI/CD',
            'Agile', 'Scrum', 'Project Management', 'Team Leadership', 'Problem Solving',
            'Critical Thinking', 'Communication', 'Time Management', 'Customer Service'
        ];

        $selectedSkills = array_slice($skills, array_rand($skills, mt_rand(5, 10)), mt_rand(5, 10));
        $skillsText = implode(', ', $selectedSkills);

        $educationLevels = [
            'Bachelor of Science in Computer Science',
            'Bachelor of Arts in Business Administration',
            'Master of Science in Information Technology',
            'Master of Business Administration',
            'Associate Degree in Web Development',
            'Ph.D. in Computer Engineering',
            'Bachelor of Engineering in Software Engineering',
            'Master of Arts in Digital Marketing',
            'Bachelor of Science in Data Science',
            'Master of Science in Cybersecurity'
        ];

        $education = $educationLevels[array_rand($educationLevels)];
        $university = [
            'University of Technology',
            'State University',
            'National College',
            'Technical Institute',
            'International University',
            'Metropolitan University',
            'Coastal College',
            'Valley State University',
            'Tech Academy',
            'Liberal Arts College'
        ][array_rand([
            'University of Technology',
            'State University',
            'National College',
            'Technical Institute',
            'International University',
            'Metropolitan University',
            'Coastal College',
            'Valley State University',
            'Tech Academy',
            'Liberal Arts College'
        ])];

        $companyNames = [
            'TechCorp Inc.',
            'Innovate Solutions',
            'Digital Dynamics',
            'Future Systems',
            'DataFlow',
            'WebPro Services',
            'Global Tech',
            'NextGen Software',
            'Bright Innovations',
            'Strategic Tech'
        ];

        $jobTitles = [
            'Software Developer',
            'Web Developer',
            'Frontend Engineer',
            'Backend Engineer',
            'Full Stack Developer',
            'DevOps Engineer',
            'Data Analyst',
            'Project Manager',
            'Product Manager',
            'QA Engineer',
            'UX/UI Designer',
            'System Administrator',
            'Database Administrator',
            'Network Engineer',
            'IT Support Specialist'
        ];

        $resume = "# {$user->name}\n";
        $resume .= "Email: {$user->email} | Phone: (555) " . mt_rand(100, 999) . "-" . mt_rand(1000, 9999) . "\n\n";
        $resume .= "## Professional Summary\n";
        $resume .= "Experienced professional with " . mt_rand(1, 15) . "+ years of experience in the technology industry. ";
        $resume .= "Skilled in " . $skillsText . ". ";
        $resume .= "Passionate about delivering high-quality solutions and driving innovation.\n\n";

        $resume .= "## Skills\n";
        $resume .= $skillsText . "\n\n";

        $resume .= "## Work Experience\n\n";

        // Generate 2-4 work experiences
        $numExperiences = mt_rand(2, 4);
        for ($i = 0; $i < $numExperiences; $i++) {
            $company = $companyNames[array_rand($companyNames)];
            $jobTitle = $jobTitles[array_rand($jobTitles)];
            $yearsAgo = 2022 - $i * 2;
            $endYear = $i === 0 ? 'Present' : (2022 - ($i * 2) + 2);

            $resume .= "### $jobTitle\n";
            $resume .= "$company | $yearsAgo - $endYear\n";
            $resume .= "- " . $this->generateJobResponsibility() . "\n";
            $resume .= "- " . $this->generateJobResponsibility() . "\n";
            $resume .= "- " . $this->generateJobResponsibility() . "\n\n";
        }

        $resume .= "## Education\n\n";
        $resume .= "### $education\n";
        $resume .= "$university | " . (2010 - mt_rand(0, 10)) . " - " . (2014 - mt_rand(0, 10)) . "\n";

        return $resume;
    }

    /**
     * Generate a random job responsibility
     *
     * @return string
     */
    private function generateJobResponsibility(): string
    {
        $responsibilities = [
            "Developed and maintained web applications using JavaScript frameworks",
            "Implemented responsive design and ensured cross-browser compatibility",
            "Collaborated with cross-functional teams to define, design, and ship new features",
            "Optimized application for maximum speed and scalability",
            "Managed and improved existing codebase, fixing bugs and adding features",
            "Designed and implemented RESTful APIs",
            "Led development team and coordinated project timelines",
            "Created technical documentation for reference and reporting",
            "Conducted code reviews and provided feedback to team members",
            "Integrated third-party services and external APIs",
            "Implemented security and data protection measures",
            "Analyzed and resolved technical issues",
            "Built efficient database queries and optimized data access",
            "Deployed and maintained applications in cloud environments",
            "Participated in agile development processes",
            "Developed automated tests to ensure software quality",
            "Mentored junior developers and provided technical guidance",
            "Researched and implemented new technologies to improve development efficiency",
            "Managed database schema design and optimization",
            "Created and maintained CI/CD pipelines"
        ];

        return $responsibilities[array_rand($responsibilities)];
    }

    /**
     * Generate a cover letter for a job application
     *
     * @param User $user
     * @param Job $job
     * @return string
     */
    private function generateCoverLetterContent(User $user, Job $job): string
    {
        $date = now()->format('F j, Y');

        $letter = "Dear Hiring Manager,\n\n";

        $letter .= "I am writing to express my interest in the {$job->title} position at {$job->company_name}. ";
        $letter .= "With my background and skills, I believe I am well-qualified for this role.\n\n";

        $letter .= "Throughout my career, I have " . $this->generateCoverLetterAchievement() . ". ";
        $letter .= "I am particularly drawn to {$job->company_name} because of its reputation for " . $this->generateCompanyQuality() . ".\n\n";

        $letter .= "In my previous roles, I have " . $this->generateCoverLetterAchievement() . " and " . $this->generateCoverLetterAchievement() . ". ";
        $letter .= "These experiences have prepared me well for the challenges of the {$job->title} position.\n\n";

        $letter .= "I am excited about the opportunity to bring my unique skills to {$job->company_name} and contribute to your team. ";
        $letter .= "Thank you for considering my application. I look forward to the possibility of discussing how I can contribute to your organization.\n\n";

        $letter .= "Sincerely,\n";
        $letter .= "{$user->name}";

        return $letter;
    }

    /**
     * Generate a random cover letter achievement
     *
     * @return string
     */
    private function generateCoverLetterAchievement(): string
    {
        $achievements = [
            "successfully led development teams on multiple projects",
            "increased application performance by optimizing code and database queries",
            "implemented new technologies that enhanced productivity",
            "reduced bug count by implementing comprehensive testing strategies",
            "designed and developed scalable solutions for enterprise clients",
            "created innovative features that improved user experience",
            "collaborated effectively with cross-functional teams",
            "managed complex projects from conception to delivery",
            "streamlined development processes that saved time and resources",
            "mentored junior developers and helped build strong technical teams",
            "contributed to open-source projects while maintaining professional responsibilities",
            "received recognition for exceptional problem-solving abilities",
            "adapted quickly to changing requirements and technology landscapes",
            "maintained high coding standards through rigorous code reviews",
            "developed comprehensive documentation that improved team efficiency"
        ];

        return $achievements[array_rand($achievements)];
    }

    /**
     * Generate a random company quality
     *
     * @return string
     */
    private function generateCompanyQuality(): string
    {
        $qualities = [
            "innovation and cutting-edge technology",
            "excellence in product development",
            "creating a positive work environment",
            "commitment to customer satisfaction",
            "industry leadership and vision",
            "promoting sustainability and social responsibility",
            "fostering professional growth and development",
            "maintaining high quality standards",
            "encouraging creativity and new ideas",
            "building strong team collaboration",
            "delivering reliable and robust solutions",
            "adapting quickly to industry changes",
            "providing exceptional value to clients",
            "building long-term partnerships",
            "driving digital transformation in the industry"
        ];

        return $qualities[array_rand($qualities)];
    }

    /**
     * Generate feedback based on application status
     *
     * @param string $status
     * @return string|null
     */
    private function generateFeedback(string $status): ?string
    {
        if (in_array($status, ['Submitted', 'Screening', 'Interview', 'Technical Assessment', 'Reference Check'])) {
            return null; // No feedback yet for in-progress applications
        }

        $positiveFeedback = [
            "Strong technical skills and excellent communication.",
            "Great problem-solving abilities demonstrated during the interview.",
            "Impressive portfolio and relevant experience for the role.",
            "Excellent cultural fit with our team values.",
            "Strong knowledge of required technologies and methodologies.",
            "Demonstrated leadership qualities and team collaboration skills.",
            "Exceptional analytical thinking and attention to detail.",
            "Clear communication and professional demeanor throughout the process.",
            "Relevant industry experience and understanding of best practices.",
            "Showed enthusiasm and genuine interest in the company."
        ];

        $negativeFeedback = [
            "Limited experience with required technologies.",
            "Communication skills did not meet the requirements for the role.",
            "Technical assessment results below expectations.",
            "Other candidates had more directly relevant experience.",
            "Misalignment with company culture and values.",
            "Salary expectations outside our budget for this position.",
            "Insufficient demonstration of critical skills during interview.",
            "References provided inconsistent feedback about work quality.",
            "Portfolio projects did not demonstrate required proficiency.",
            "Concerns about ability to handle the specific challenges of the role."
        ];

        if ($status === 'Hired' || $status === 'Offered') {
            return $positiveFeedback[array_rand($positiveFeedback)];
        } elseif ($status === 'Rejected') {
            return $negativeFeedback[array_rand($negativeFeedback)];
        } elseif ($status === 'Withdrawn') {
            return "Candidate withdrew application. " . ["Cited another offer.", "Cited personal reasons.", "Cited relocation issues.", "No specific reason provided."][array_rand(["Cited another offer.", "Cited personal reasons.", "Cited relocation issues.", "No specific reason provided."])];
        }

        return null;
    }

    /**
     * Generate notes based on application status
     *
     * @param string $status
     * @return string|null
     */
    private function generateNotes(string $status): ?string
    {
        $screeningNotes = [
            "Resume shows relevant experience. Worth proceeding to interview.",
            "Background matches our requirements. Schedule initial call.",
            "Strong portfolio but limited industry experience. Proceed cautiously.",
            "Excellent educational background. Good potential candidate.",
            "Previous experience at competitive companies. Promising candidate."
        ];

        $interviewNotes = [
            "Performed well in initial interview. Technical skills are strong.",
            "Good cultural fit but some technical areas need deeper assessment.",
            "Articulate and professional. Recommend moving forward.",
            "Mixed performance in the interview. Some concerns about technical depth.",
            "Strong communication skills. Set up technical assessment."
        ];

        $technicalNotes = [
            "Completed assessment with high scores. Promising technical skills.",
            "Assessment results were average. Consider practical experience as well.",
            "Demonstrated good problem-solving approach. Some gaps in specific technologies.",
            "Strong in core technologies but weaker in some specialized areas.",
            "Technical skills meet requirements. Proceed with reference checks."
        ];

        $referenceNotes = [
            "References confirm strong work ethic and technical abilities.",
            "Previous managers gave positive feedback about teamwork.",
            "References validated skills and experience listed on resume.",
            "Mixed feedback from references. Some concerns about deadline management.",
            "Strong endorsements from previous colleagues and supervisors."
        ];

        $finalNotes = [
            "All stages completed successfully. Ready for offer.",
            "Candidate exceeds requirements in most areas. Highly recommended.",
            "Some concerns but overall a solid candidate. Recommend proceeding.",
            "Not the strongest technically but exceptional soft skills.",
            "Overall assessment positive. Good addition to the team."
        ];

        switch ($status) {
            case 'Screening':
                return $screeningNotes[array_rand($screeningNotes)];
            case 'Interview':
                return $interviewNotes[array_rand($interviewNotes)];
            case 'Technical Assessment':
                return $technicalNotes[array_rand($technicalNotes)];
            case 'Reference Check':
                return $referenceNotes[array_rand($referenceNotes)];
            case 'Offered':
            case 'Hired':
            case 'Rejected':
                return $finalNotes[array_rand($finalNotes)];
            default:
                return null;
        }
    }
}
