<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Companies posting jobs
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('industry')->default('automotive'); // automotive, industrial, heavy-equipment
            $table->string('logo_url')->nullable();
            $table->string('location');
            $table->string('state', 2)->nullable();
            $table->string('website')->nullable();
            $table->string('size')->nullable(); // 1-10, 11-50, 51-200, 201-500, 500+
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Job positions
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('department'); // service, sales, parts, body-shop, admin, management
            $table->string('employment_type')->default('full-time'); // full-time, part-time, contract, temp
            $table->string('experience_level')->default('mid'); // entry, mid, senior, lead
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('salary_period')->default('year'); // hour, year
            $table->string('location');
            $table->boolean('is_remote')->default(false);
            $table->string('status')->default('active'); // draft, active, paused, closed, filled
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('closes_at')->nullable();
            $table->timestamps();
        });

        // Candidates applying
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('headline')->nullable(); // "Master Technician | 15yr ASE Certified"
            $table->text('summary')->nullable();
            $table->string('resume_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->json('skills')->nullable(); // ["ASE Certified", "Diesel", "Transmission"]
            $table->json('certifications')->nullable(); // ["ASE Master", "EPA 608"]
            $table->integer('experience_years')->nullable();
            $table->string('desired_salary')->nullable();
            $table->string('availability')->default('immediate'); // immediate, 2-weeks, 1-month, passive
            $table->string('source')->default('direct'); // direct, referral, linkedin, indeed, widget
            $table->timestamps();
        });

        // Applications linking candidates to positions
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->string('stage')->default('new'); // new, screening, interview, assessment, offer, hired, rejected
            $table->text('cover_letter')->nullable();
            $table->decimal('match_score', 5, 2)->nullable(); // AI match percentage
            $table->text('notes')->nullable();
            $table->json('stage_history')->nullable(); // [{stage, changed_at, changed_by}]
            $table->timestamp('applied_at');
            $table->timestamps();
            $table->unique(['position_id', 'candidate_id']);
        });

        // Interview scheduling
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('phone'); // phone, video, in-person, technical, panel
            $table->timestamp('scheduled_at');
            $table->integer('duration_minutes')->default(30);
            $table->string('location')->nullable(); // Zoom link or physical address
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, no-show
            $table->text('feedback')->nullable();
            $table->integer('rating')->nullable(); // 1-5
            $table->timestamps();
        });

        // Activity log for pipeline tracking
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // stage_change, note_added, interview_scheduled, email_sent
            $table->text('description');
            $table->nullableMorphs('subject'); // polymorphic to application, candidate, position
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
        Schema::dropIfExists('interviews');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('candidates');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('companies');
    }
};
