<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Interview;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@drivehire.com',
            'password' => bcrypt('password'),
        ]);

        // Companies
        $companies = [
            [
                'name' => 'Pinnacle Auto Group',
                'slug' => 'pinnacle-auto-group',
                'description' => 'Pinnacle Auto Group is one of the largest multi-brand dealership groups in the Midwest, representing 14 brands across 8 locations. With over 500 employees and growing, we\'re committed to providing exceptional customer experiences through our team of dedicated automotive professionals.',
                'industry' => 'automotive',
                'location' => 'Columbus, OH',
                'state' => 'OH',
                'website' => 'https://pinnacleautogroup.com',
                'size' => '201-500',
                'contact_email' => 'hr@pinnacleautogroup.com',
            ],
            [
                'name' => 'Heartland Equipment Co.',
                'slug' => 'heartland-equipment',
                'description' => 'Heartland Equipment has been the trusted name in heavy machinery sales and service across the Great Plains since 1987. We specialize in Caterpillar, John Deere, and Komatsu equipment for construction, mining, and agriculture.',
                'industry' => 'industrial',
                'location' => 'Omaha, NE',
                'state' => 'NE',
                'website' => 'https://heartlandequip.com',
                'size' => '51-200',
                'contact_email' => 'careers@heartlandequip.com',
            ],
            [
                'name' => 'Sterling Collision Centers',
                'slug' => 'sterling-collision',
                'description' => 'Sterling Collision Centers operates 12 state-of-the-art collision repair facilities across the Southeast. We\'re I-CAR Gold certified and committed to delivering OEM-quality repairs with cutting-edge technology.',
                'industry' => 'automotive',
                'location' => 'Atlanta, GA',
                'state' => 'GA',
                'website' => 'https://sterlingcollision.com',
                'size' => '51-200',
                'contact_email' => 'jobs@sterlingcollision.com',
            ],
            [
                'name' => 'Pacific Diesel & Power',
                'slug' => 'pacific-diesel',
                'description' => 'Pacific Diesel & Power is the West Coast\'s premier diesel engine and power systems specialist. From marine vessels to industrial generators, our technicians are factory-trained on Cummins, Detroit, and MTU platforms.',
                'industry' => 'industrial',
                'location' => 'Portland, OR',
                'state' => 'OR',
                'size' => '11-50',
                'contact_email' => 'hr@pacificdiesel.com',
            ],
        ];

        $companyModels = [];
        foreach ($companies as $c) {
            $companyModels[] = Company::create($c);
        }

        // Positions
        $positions = [
            ['company' => 0, 'title' => 'Master Technician – European Line', 'slug' => 'master-tech-european', 'department' => 'service', 'employment_type' => 'full-time', 'experience_level' => 'senior', 'salary_min' => 75000, 'salary_max' => 105000, 'location' => 'Columbus, OH', 'views_count' => 342, 'applications_count' => 0, 'published_at' => now()->subDays(5),
                'description' => 'We are seeking an ASE Master Certified Technician with deep expertise in European vehicle platforms (BMW, Mercedes-Benz, Audi). You will diagnose and repair complex mechanical, electrical, and electronic systems while mentoring junior technicians. This role includes access to our new $2M diagnostic lab with factory scan tools.',
                'requirements' => "ASE Master Technician Certification\nMinimum 8 years experience with European vehicles\nFactory training from BMW, Mercedes-Benz, or Audi preferred\nExperience with ADAS calibration and EV/hybrid systems\nStrong diagnostic skills using factory and aftermarket scan tools\nClean driving record",
                'benefits' => "Competitive pay with flat rate + bonus structure\nCompany-provided tools and uniforms\nFactory training and certification sponsorship\nHealth, dental, and vision insurance\n401(k) with company match\nPaid time off and holidays\nEmployee vehicle purchase program",
            ],
            ['company' => 0, 'title' => 'Service Advisor', 'slug' => 'service-advisor-pinnacle', 'department' => 'service', 'employment_type' => 'full-time', 'experience_level' => 'mid', 'salary_min' => 55000, 'salary_max' => 85000, 'location' => 'Columbus, OH', 'views_count' => 189, 'applications_count' => 0, 'published_at' => now()->subDays(3),
                'description' => 'Join our high-volume service department as a Service Advisor. You\'ll be the primary point of contact for customers, translating technical diagnoses into clear language, managing repair orders, and driving service revenue. We average 60+ ROs per advisor per month.',
                'requirements' => "3+ years as a Service Advisor at a franchised dealership\nCDK/Reynolds & Reynolds experience\nStrong customer service and communication skills\nAbility to upsell maintenance packages ethically\nBasic automotive mechanical knowledge",
                'benefits' => "Base salary plus commission (uncapped)\nHealth benefits package\nPaid training and development\nEmployee vehicle purchase program\nPerformance bonuses",
            ],
            ['company' => 0, 'title' => 'F&I Manager', 'slug' => 'fi-manager', 'department' => 'sales', 'employment_type' => 'full-time', 'experience_level' => 'senior', 'salary_min' => 90000, 'salary_max' => 150000, 'location' => 'Columbus, OH', 'views_count' => 156, 'applications_count' => 0, 'published_at' => now()->subDays(7),
                'description' => 'Manage the Finance & Insurance department for our flagship dealership. Structure deals, present aftermarket products, and ensure compliance with all state and federal lending regulations. Our top F&I managers earn $150K+ annually.',
                'requirements' => "5+ years F&I experience at a franchised dealership\nAFIP Certification preferred\nStrong knowledge of lending compliance and regulations\nExperience with DealerTrack and RouteOne\nProven track record of high PVR",
                'benefits' => "Base salary plus per-deal commission\nManagement bonus program\nFull benefits package\nCompany vehicle\nRelocation assistance available",
            ],
            ['company' => 0, 'title' => 'Parts Counter Specialist', 'slug' => 'parts-counter', 'department' => 'parts', 'employment_type' => 'full-time', 'experience_level' => 'entry', 'salary_min' => 18, 'salary_max' => 24, 'salary_period' => 'hour', 'location' => 'Columbus, OH', 'views_count' => 87, 'applications_count' => 0, 'published_at' => now()->subDays(2),
                'description' => 'Looking for a detail-oriented parts professional to manage our retail and wholesale parts counter. You\'ll process orders, manage inventory, and work closely with service technicians to ensure timely parts delivery.',
                'requirements' => "1+ year automotive parts experience\nKnowledge of parts lookup systems\nStrong organizational skills\nAbility to lift 50+ lbs regularly\nValid driver\'s license",
                'benefits' => "Competitive hourly rate\nOvertime opportunities\nHealth insurance\nEmployee discount on parts\n401(k) plan",
            ],
            ['company' => 1, 'title' => 'Heavy Equipment Field Technician', 'slug' => 'heavy-equip-field-tech', 'department' => 'service', 'employment_type' => 'full-time', 'experience_level' => 'mid', 'salary_min' => 65000, 'salary_max' => 90000, 'location' => 'Omaha, NE', 'views_count' => 203, 'applications_count' => 0, 'published_at' => now()->subDays(4),
                'description' => 'Travel to customer job sites across Nebraska and western Iowa to diagnose and repair heavy construction and mining equipment. You\'ll work on Caterpillar, Komatsu, and John Deere machines including excavators, dozers, loaders, and haul trucks.',
                'requirements' => "4+ years heavy equipment repair experience\nCaterpillar or John Deere factory training preferred\nStrong hydraulic, electrical, and diesel diagnostic skills\nWelding and fabrication abilities a plus\nValid CDL or ability to obtain within 90 days\nWillingness to travel up to 60%",
                'benefits' => "Competitive salary with overtime\nCompany service truck and tools\nFactory training sponsorship\nHealth, dental, and vision coverage\nPer diem for overnight travel\n401(k) with match\nBoot and tool allowance",
            ],
            ['company' => 1, 'title' => 'Territory Sales Manager – Construction', 'slug' => 'territory-sales-construction', 'department' => 'sales', 'employment_type' => 'full-time', 'experience_level' => 'senior', 'salary_min' => 80000, 'salary_max' => 130000, 'location' => 'Lincoln, NE', 'views_count' => 145, 'applications_count' => 0, 'published_at' => now()->subDays(8),
                'description' => 'Own the customer relationship for construction equipment sales across southeast Nebraska. You\'ll manage a $15M annual territory, working with contractors, municipalities, and mining operations to spec and sell new and used equipment.',
                'requirements' => "5+ years B2B sales in heavy equipment or industrial\nEstablished relationships in the construction industry\nAbility to read and interpret equipment specifications\nStrong negotiation and closing skills\nBachelor\'s degree preferred\nClean driving record and willingness to travel",
                'benefits' => "Base salary plus uncapped commission\nCompany vehicle and fuel card\nFull benefits package\nExpense account\nPresident\'s Club trip for top performers",
            ],
            ['company' => 2, 'title' => 'Collision Repair Estimator', 'slug' => 'collision-estimator', 'department' => 'body-shop', 'employment_type' => 'full-time', 'experience_level' => 'mid', 'salary_min' => 55000, 'salary_max' => 80000, 'location' => 'Atlanta, GA', 'views_count' => 178, 'applications_count' => 0, 'published_at' => now()->subDays(6),
                'description' => 'Write accurate collision repair estimates using CCC ONE or Mitchell. You\'ll inspect damaged vehicles, negotiate supplements with insurance adjusters, and manage the customer experience from intake to delivery. I-CAR Platinum individual certification preferred.',
                'requirements' => "3+ years collision estimating experience\nProficiency with CCC ONE, Mitchell, or Audatex\nI-CAR certifications preferred\nStrong knowledge of DRP programs\nExcellent communication and negotiation skills\nAbility to read OEM repair procedures",
                'benefits' => "Competitive salary with bonus potential\nHealth and dental insurance\nI-CAR training provided\nPaid time off\n401(k) plan",
            ],
            ['company' => 2, 'title' => 'ADAS Calibration Technician', 'slug' => 'adas-calibration-tech', 'department' => 'body-shop', 'employment_type' => 'full-time', 'experience_level' => 'mid', 'salary_min' => 60000, 'salary_max' => 85000, 'location' => 'Atlanta, GA', 'views_count' => 234, 'applications_count' => 0, 'published_at' => now()->subDays(1),
                'description' => 'Specialize in ADAS calibration for post-collision repairs. You\'ll perform static and dynamic calibrations on cameras, radar, and LiDAR systems across all major vehicle brands. This is a rapidly growing specialty — we\'ll invest in your training.',
                'requirements' => "2+ years automotive technology experience\nADAS calibration certification or training\nExperience with Autel, Hunter, or OEM calibration equipment\nStrong electrical diagnostic skills\nAttention to detail and precision\nValid driver\'s license with clean record",
                'benefits' => "Industry-leading pay for ADAS specialists\nFull factory training program\nCompany-provided calibration equipment\nHealth, dental, and vision\nCareer advancement path to lead technician",
            ],
            ['company' => 3, 'title' => 'Marine Diesel Mechanic', 'slug' => 'marine-diesel-mechanic', 'department' => 'service', 'employment_type' => 'full-time', 'experience_level' => 'mid', 'salary_min' => 60000, 'salary_max' => 85000, 'location' => 'Portland, OR', 'views_count' => 167, 'applications_count' => 0, 'published_at' => now()->subDays(3),
                'description' => 'Service and repair marine diesel engines for commercial fishing vessels and recreational yachts at our waterfront facility. You\'ll work on Cummins, John Deere, and Caterpillar marine engines ranging from 100 to 2,000 HP.',
                'requirements' => "4+ years diesel engine experience (marine preferred)\nCummins or Caterpillar marine certification a plus\nKnowledge of marine electrical systems\nAbility to work in confined engine rooms\nStrong troubleshooting skills\nValid TWIC card or ability to obtain",
                'benefits' => "Competitive hourly rate with OT\nMarine-specific training programs\nTool allowance\nHealth insurance\nWaterfront work environment\nBoat access for personal use",
            ],
            ['company' => 3, 'title' => 'Generator Service Technician', 'slug' => 'generator-service-tech', 'department' => 'service', 'employment_type' => 'full-time', 'experience_level' => 'entry', 'salary_min' => 22, 'salary_max' => 32, 'salary_period' => 'hour', 'location' => 'Portland, OR', 'views_count' => 98, 'applications_count' => 0, 'published_at' => now()->subDays(2),
                'description' => 'Maintain and repair industrial standby and prime power generators for hospitals, data centers, and critical infrastructure. Travel to customer sites to perform PM services, load bank testing, and emergency repairs.',
                'requirements' => "1+ year experience with generator systems or diesel engines\nElectrical knowledge (single and three-phase power)\nAbility to read schematics and wiring diagrams\nValid driver\'s license\nWillingness to be on-call for emergencies\nPhysical ability to work in all weather conditions",
                'benefits' => "Competitive pay with on-call premium\nCompany service vehicle\nFactory training on Generac, Cummins, and Kohler\nHealth and dental insurance\n401(k)\nTool purchase program",
            ],
        ];

        $positionModels = [];
        foreach ($positions as $p) {
            $companyIdx = $p['company'];
            unset($p['company']);
            $p['company_id'] = $companyModels[$companyIdx]->id;
            $p['salary_period'] = $p['salary_period'] ?? 'year';
            $p['status'] = 'active';
            $positionModels[] = Position::create($p);
        }

        // Candidates
        $candidates = [
            ['first_name' => 'Marcus', 'last_name' => 'Chen', 'email' => 'marcus.chen@email.com', 'phone' => '(614) 555-0142', 'location' => 'Columbus, OH', 'headline' => 'ASE Master Technician | BMW & Mercedes Specialist | 12 Years', 'summary' => 'Master technician with over 12 years of experience specializing in European vehicle platforms. Currently working at a BMW dealership but looking for a leadership role where I can mentor junior techs while continuing hands-on diagnostic work.', 'experience_years' => 12, 'skills' =>['ASE Master', 'BMW', 'Mercedes-Benz', 'ADAS Calibration', 'EV/Hybrid', 'Diagnostic', 'ISTA'], 'certifications' =>['ASE Master Technician', 'BMW Factory Trained', 'EPA 608'], 'availability' => '2-weeks', 'source' => 'linkedin', 'desired_salary' => '$95K-$105K'],
            ['first_name' => 'Sarah', 'last_name' => 'Blackwood', 'email' => 'sarah.blackwood@email.com', 'phone' => '(402) 555-0198', 'location' => 'Omaha, NE', 'headline' => 'Heavy Equipment Specialist | CAT Certified | 8 Years Field Experience', 'summary' => 'Field service technician specializing in Caterpillar heavy equipment. Experienced with everything from skid steers to mining haul trucks. I thrive in challenging field conditions.', 'experience_years' => 8, 'skills' =>['Caterpillar', 'Hydraulics', 'Diesel', 'Welding', 'Electrical', 'CDL Class A'], 'certifications' =>['CAT ThinkBIG Graduate', 'CDL Class A', 'MSHA Certified'], 'availability' => 'immediate', 'source' => 'indeed', 'desired_salary' => '$80K-$90K'],
            ['first_name' => 'James', 'last_name' => 'Rodriguez', 'email' => 'j.rodriguez@email.com', 'phone' => '(404) 555-0267', 'location' => 'Atlanta, GA', 'headline' => 'Collision Repair Estimator | I-CAR Platinum | CCC ONE Expert', 'summary' => 'Experienced collision estimator with I-CAR Platinum individual certification. Expert in CCC ONE and Mitchell. Consistent supplement approval rate of 94%.', 'experience_years' => 6, 'skills' =>['CCC ONE', 'Mitchell', 'DRP Programs', 'Supplements', 'OEM Procedures', 'Customer Relations'], 'certifications' =>['I-CAR Platinum Individual', 'ASE B6'], 'availability' => '2-weeks', 'source' => 'referral', 'desired_salary' => '$70K-$80K'],
            ['first_name' => 'Emily', 'last_name' => 'Torres', 'email' => 'emily.torres@email.com', 'phone' => '(503) 555-0334', 'location' => 'Portland, OR', 'headline' => 'Marine & Industrial Diesel | Cummins Certified | 5 Years', 'summary' => 'Diesel technician with experience across marine, generator, and heavy-duty truck applications. Cummins Certified Master Mechanic.', 'experience_years' => 5, 'skills' =>['Cummins', 'Diesel', 'Marine Engines', 'Generators', 'Electrical', 'Troubleshooting'], 'certifications' =>['Cummins Master Mechanic', 'TWIC Card', 'EPA 608'], 'availability' => 'immediate', 'source' => 'direct', 'desired_salary' => '$70K-$85K'],
            ['first_name' => 'David', 'last_name' => 'Park', 'email' => 'david.park@email.com', 'phone' => '(614) 555-0455', 'location' => 'Dublin, OH', 'headline' => 'Senior Service Advisor | CDK Expert | $2M+ Monthly Revenue', 'summary' => 'Top-performing service advisor with a track record of $2M+ monthly service revenue. Expert in CDK DMS and customer relationship management.', 'experience_years' => 7, 'skills' =>['CDK', 'Customer Service', 'Upselling', 'DMS Systems', 'Warranty Processing', 'Team Leadership'], 'certifications' =>['Toyota Service Advisor Certified'], 'availability' => '1-month', 'source' => 'linkedin', 'desired_salary' => '$75K-$85K'],
            ['first_name' => 'Rachel', 'last_name' => 'Kim', 'email' => 'rachel.kim@email.com', 'phone' => '(404) 555-0512', 'location' => 'Decatur, GA', 'headline' => 'ADAS Calibration Specialist | Autel & Hunter Certified | 3 Years', 'summary' => 'Early-career ADAS specialist with certifications from Autel and Hunter. Performed over 800 static and dynamic calibrations.', 'experience_years' => 3, 'skills' =>['ADAS Calibration', 'Autel ADAS', 'Hunter HawkEye', 'Radar', 'Camera Systems', 'LiDAR'], 'certifications' =>['Autel ADAS Certified', 'I-CAR ADAS', 'ASE A6'], 'availability' => 'immediate', 'source' => 'direct', 'desired_salary' => '$65K-$85K'],
            ['first_name' => 'Mike', 'last_name' => 'Johnson', 'email' => 'mike.johnson@email.com', 'phone' => '(402) 555-0678', 'location' => 'Lincoln, NE', 'headline' => 'Equipment Sales | $15M Territory | 10 Years B2B', 'summary' => 'Territory sales veteran with 10 years in heavy equipment and industrial sales. Currently managing a $12M territory.', 'experience_years' => 10, 'skills' =>['B2B Sales', 'Heavy Equipment', 'Territory Management', 'Negotiation', 'CRM', 'Construction Industry'], 'certifications' =>[], 'availability' => '1-month', 'source' => 'linkedin', 'desired_salary' => '$100K-$130K OTE'],
            ['first_name' => 'Ana', 'last_name' => 'Petrov', 'email' => 'ana.petrov@email.com', 'phone' => '(614) 555-0789', 'location' => 'Westerville, OH', 'headline' => 'F&I Manager | AFIP Certified | $2,800 PVR', 'summary' => 'Experienced Finance & Insurance Manager with AFIP certification and a consistent PVR of $2,800+.', 'experience_years' => 8, 'skills' =>['F&I', 'DealerTrack', 'RouteOne', 'Compliance', 'Deal Structuring', 'Aftermarket Products'], 'certifications' =>['AFIP Certified', 'Zurich F&I Trained'], 'availability' => '2-weeks', 'source' => 'referral', 'desired_salary' => '$120K-$150K OTE'],
            ['first_name' => 'Tyler', 'last_name' => 'Brooks', 'email' => 'tyler.brooks@email.com', 'phone' => '(503) 555-0890', 'location' => 'Vancouver, WA', 'headline' => 'Generator & Power Systems Tech | Entry Level | Eager to Learn', 'summary' => 'Recent diesel technology graduate looking to specialize in power generation systems. Completed internship at a Generac dealer.', 'experience_years' => 1, 'skills' =>['Diesel Engines', 'Generators', 'Electrical Basics', 'PM Service', 'Load Bank Testing'], 'certifications' =>['Diesel Technology AAS'], 'availability' => 'immediate', 'source' => 'direct', 'desired_salary' => '$24-$28/hr'],
            ['first_name' => 'Lisa', 'last_name' => 'Nguyen', 'email' => 'lisa.nguyen@email.com', 'phone' => '(614) 555-0923', 'location' => 'Columbus, OH', 'headline' => 'Parts Professional | 3 Years Multi-Brand | Inventory Expert', 'summary' => 'Parts counter specialist with experience across Honda, Toyota, and Hyundai dealerships. Known for fast, accurate order fulfillment.', 'experience_years' => 3, 'skills' =>['Parts Lookup', 'Inventory Management', 'DMS Systems', 'Customer Service', 'Wholesale', 'Shipping/Receiving'], 'certifications' =>['Honda Parts Certified'], 'availability' => 'immediate', 'source' => 'indeed', 'desired_salary' => '$20-$24/hr'],
        ];

        $candidateModels = [];
        foreach ($candidates as $c) {
            $candidateModels[] = Candidate::create($c);
        }

        // Applications
        $applications = [
            ['candidate' => 0, 'position' => 0, 'stage' => 'interview', 'match_score' => 94.5, 'days_ago' => 4],
            ['candidate' => 0, 'position' => 1, 'stage' => 'rejected', 'match_score' => 45.2, 'days_ago' => 4],
            ['candidate' => 1, 'position' => 4, 'stage' => 'assessment', 'match_score' => 91.3, 'days_ago' => 6],
            ['candidate' => 2, 'position' => 6, 'stage' => 'offer', 'match_score' => 96.8, 'days_ago' => 8],
            ['candidate' => 3, 'position' => 8, 'stage' => 'screening', 'match_score' => 87.4, 'days_ago' => 2],
            ['candidate' => 4, 'position' => 1, 'stage' => 'interview', 'match_score' => 89.1, 'days_ago' => 3],
            ['candidate' => 5, 'position' => 7, 'stage' => 'new', 'match_score' => 92.7, 'days_ago' => 1],
            ['candidate' => 6, 'position' => 5, 'stage' => 'screening', 'match_score' => 85.6, 'days_ago' => 5],
            ['candidate' => 7, 'position' => 2, 'stage' => 'interview', 'match_score' => 93.2, 'days_ago' => 5],
            ['candidate' => 8, 'position' => 9, 'stage' => 'new', 'match_score' => 72.4, 'days_ago' => 1],
            ['candidate' => 9, 'position' => 3, 'stage' => 'screening', 'match_score' => 81.9, 'days_ago' => 2],
            ['candidate' => 1, 'position' => 8, 'stage' => 'new', 'match_score' => 67.3, 'days_ago' => 2],
            ['candidate' => 3, 'position' => 9, 'stage' => 'new', 'match_score' => 78.5, 'days_ago' => 2],
        ];

        $appModels = [];
        foreach ($applications as $a) {
            $appliedAt = now()->subDays($a['days_ago']);
            $history = [['stage' => 'new', 'changed_at' => $appliedAt->toISOString()]];

            $stageOrder = ['new', 'screening', 'interview', 'assessment', 'offer', 'hired'];
            $currentIdx = array_search($a['stage'], $stageOrder);
            if ($a['stage'] === 'rejected') $currentIdx = 1;

            for ($i = 1; $i <= $currentIdx; $i++) {
                $history[] = ['stage' => $stageOrder[$i], 'from' => $stageOrder[$i-1], 'changed_at' => $appliedAt->copy()->addDays($i)->toISOString()];
            }
            if ($a['stage'] === 'rejected') {
                $history[] = ['stage' => 'rejected', 'from' => 'screening', 'changed_at' => $appliedAt->copy()->addDays(2)->toISOString()];
            }

            $appModels[] = Application::create([
                'position_id' => $positionModels[$a['position']]->id,
                'candidate_id' => $candidateModels[$a['candidate']]->id,
                'stage' => $a['stage'],
                'match_score' => $a['match_score'],
                'applied_at' => $appliedAt,
                'stage_history' => $history,
            ]);

            $positionModels[$a['position']]->increment('applications_count');
        }

        // Interviews
        $interviews = [
            ['app_idx' => 0, 'type' => 'phone', 'days_from_now' => -2, 'duration' => 30, 'status' => 'completed', 'rating' => 5, 'feedback' => 'Extremely knowledgeable on European platforms. Deep understanding of BMW ISTA and ADAS systems. Recommended for in-person interview.'],
            ['app_idx' => 0, 'type' => 'in-person', 'days_from_now' => 2, 'duration' => 60, 'status' => 'scheduled'],
            ['app_idx' => 2, 'type' => 'phone', 'days_from_now' => -5, 'duration' => 30, 'status' => 'completed', 'rating' => 5, 'feedback' => 'Outstanding candidate. I-CAR Platinum certified with excellent communication skills.'],
            ['app_idx' => 2, 'type' => 'in-person', 'days_from_now' => -3, 'duration' => 45, 'status' => 'completed', 'rating' => 4, 'feedback' => 'Strong technical skills. Presented well with the team. Moving to offer.'],
            ['app_idx' => 5, 'type' => 'video', 'days_from_now' => 1, 'duration' => 45, 'status' => 'scheduled'],
            ['app_idx' => 8, 'type' => 'phone', 'days_from_now' => -1, 'duration' => 30, 'status' => 'completed', 'rating' => 4, 'feedback' => 'Solid F&I background. AFIP certified. PVR track record is impressive.'],
            ['app_idx' => 8, 'type' => 'in-person', 'days_from_now' => 3, 'duration' => 60, 'status' => 'scheduled'],
        ];

        foreach ($interviews as $i) {
            Interview::create([
                'application_id' => $appModels[$i['app_idx']]->id,
                'type' => $i['type'],
                'scheduled_at' => now()->addDays($i['days_from_now'])->setHour(rand(9, 15))->setMinute(0),
                'duration_minutes' => $i['duration'],
                'status' => $i['status'],
                'rating' => $i['rating'] ?? null,
                'feedback' => $i['feedback'] ?? null,
                'location' => $i['type'] === 'video' ? 'Zoom Meeting' : ($i['type'] === 'phone' ? null : 'Main Office'),
            ]);
        }

        // Activities
        $activityData = [
            ['type' => 'stage_change', 'desc' => 'Moved Marcus Chen from Screening to Interview for Master Technician – European Line', 'company' => 0, 'hours_ago' => 2],
            ['type' => 'interview_scheduled', 'desc' => 'In-person interview scheduled with Marcus Chen for Master Technician – European Line', 'company' => 0, 'hours_ago' => 3],
            ['type' => 'stage_change', 'desc' => 'Moved James Rodriguez from Interview to Offer for Collision Repair Estimator', 'company' => 2, 'hours_ago' => 5],
            ['type' => 'note_added', 'desc' => 'Offer letter prepared for James Rodriguez — $75K base + quarterly bonus', 'company' => 2, 'hours_ago' => 4],
            ['type' => 'stage_change', 'desc' => 'Moved Sarah Blackwood from Interview to Assessment for Heavy Equipment Field Technician', 'company' => 1, 'hours_ago' => 8],
            ['type' => 'interview_scheduled', 'desc' => 'Video interview scheduled with David Park for Service Advisor', 'company' => 0, 'hours_ago' => 6],
            ['type' => 'stage_change', 'desc' => 'Rachel Kim applied for ADAS Calibration Technician — 92.7% match score', 'company' => 2, 'hours_ago' => 10],
            ['type' => 'email_sent', 'desc' => 'Screening questionnaire sent to Emily Torres for Marine Diesel Mechanic', 'company' => 3, 'hours_ago' => 12],
            ['type' => 'stage_change', 'desc' => 'Moved Ana Petrov from Screening to Interview for F&I Manager', 'company' => 0, 'hours_ago' => 18],
            ['type' => 'note_added', 'desc' => 'Lisa Nguyen passed initial phone screen — scheduling parts knowledge assessment', 'company' => 0, 'hours_ago' => 20],
        ];

        foreach ($activityData as $a) {
            Activity::create([
                'type' => $a['type'],
                'description' => $a['desc'],
                'company_id' => $companyModels[$a['company']]->id,
                'created_at' => now()->subHours($a['hours_ago']),
                'updated_at' => now()->subHours($a['hours_ago']),
            ]);
        }
    }
}
