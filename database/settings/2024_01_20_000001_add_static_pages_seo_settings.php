<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Home
        $this->migrator->add('seo.home_title', 'Find Your Dream Scholarship - Scholarpeep');
        $this->migrator->add('seo.home_description', 'Discover thousands of verified international scholarships, grants, and financial aid opportunities. Start your study abroad journey today.');

        // Scholarships
        $this->migrator->add('seo.scholarships_title', 'Browse Scholarships - Scholarpeep');
        $this->migrator->add('seo.scholarships_description', 'Explore verified scholarships for undergraduate, masters, and PhD studies. Filter by country, field of study, and award amount.');

        // Blog
        $this->migrator->add('seo.blog_title', 'Scholarship Tips & Guides - Scholarpeep Blog');
        $this->migrator->add('seo.blog_description', 'Expert advice, success stories, and guides on how to win scholarships and study abroad.');

        // Resources
        $this->migrator->add('seo.resources_title', 'Student Resources & Tools - Scholarpeep');
        $this->migrator->add('seo.resources_description', 'Free templates, guides, and tools to help you craft winning scholarship applications.');

        // FAQ
        $this->migrator->add('seo.faq_title', 'Frequently Asked Questions - Scholarpeep');
        $this->migrator->add('seo.faq_description', 'Get answers to common questions about scholarships, financial aid, and calculating your chances of winning.');

        // Success Stories
        $this->migrator->add('seo.stories_title', 'Success Stories - Scholarpeep');
        $this->migrator->add('seo.stories_description', 'Read inspiring stories from students who won life-changing scholarships. Learn from their experiences.');

        // Tools
        $this->migrator->add('seo.tools_title', 'Affiliate Tools & Resources - Scholarpeep');
        $this->migrator->add('seo.tools_description', 'Essential tools and services for students: language tests, visa assistance, travel insurance, and more.');
    }
};
