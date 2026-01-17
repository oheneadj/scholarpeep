<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            ['question' => 'What is Scholarpeep?', 'answer' => 'Scholarpeep is a platform connecting students with scholarship opportunities worldwide.', 'category' => 'General'],
            ['question' => 'Is Scholarpeep free to use?', 'answer' => 'Yes, creating an account and searching for scholarships is completely free.', 'category' => 'General'],
            ['question' => 'How do I create an account?', 'answer' => 'Click the "Sign Up" button in the top right corner and follow the instructions.', 'category' => 'General'],
            ['question' => 'Can I receive email alerts?', 'answer' => 'Yes, you can subscribe to our newsletter to receive weekly scholarship updates.', 'category' => 'General'],

            // Applications
            ['question' => 'How do I apply for a scholarship?', 'answer' => 'Each scholarship page has an "Apply Now" button that directs you to the official application portal.', 'category' => 'Applications'],
            ['question' => 'What documents do I usually need?', 'answer' => 'Common documents include transcripts, recommendation letters, a CV/Resume, and a personal statement.', 'category' => 'Applications'],
            ['question' => 'How to write a winning essay?', 'answer' => 'Focus on your unique story, answer the prompt directly, and proofread carefully.', 'category' => 'Applications'],
            ['question' => 'Can I apply for multiple scholarships?', 'answer' => 'Absolutely! We encourage you to apply to as many relevant scholarships as possible.', 'category' => 'Applications'],
            ['question' => 'What is a Statement of Purpose?', 'answer' => 'It is an essay stating your purpose for applying, your background, and your future goals.', 'category' => 'Applications'],
            
            // Eligibility
            ['question' => 'Are there scholarships for international students?', 'answer' => 'Yes, many scholarships listed on Scholarpeep are open to international students.', 'category' => 'Eligibility'],
            ['question' => 'Can high school students apply?', 'answer' => 'Yes, there are many scholarships specifically for high school seniors and juniors.', 'category' => 'Eligibility'],
            ['question' => 'Do I need a high GPA?', 'answer' => 'Not always. While some consist on merit, many focus on need, community service, or specific talents.', 'category' => 'Eligibility'],
            ['question' => 'Are there scholarships for graduate students?', 'answer' => 'Yes, we list scholarships for Masters, PhD, and Post-doc levels.', 'category' => 'Eligibility'],

            // Technical
            ['question' => 'How do I reset my password?', 'answer' => 'Go to the login page and click "Forgot Password" to receive a reset link.', 'category' => 'Technical'],
            ['question' => 'How can I update my profile?', 'answer' => 'Log in and navigate to your dashboard settings to update your information.', 'category' => 'Technical'],
            ['question' => 'Why am I not receiving emails?', 'answer' => 'Check your spam folder and ensure your email address is correct in your settings.', 'category' => 'Technical'],

            // Financial
            ['question' => 'Do I have to pay back a scholarship?', 'answer' => 'No, scholarships are "gift aid" and do not need to be repaid.', 'category' => 'Financial'],
            ['question' => 'Is a scholarship taxable?', 'answer' => 'It depends on your country and how the funds are used (e.g., tuition vs. room and board). Consult a tax professional.', 'category' => 'Financial'],
            ['question' => 'What is a fully funded scholarship?', 'answer' => 'It covers tuition, living expenses, travel, and sometimes insurance and books.', 'category' => 'Financial'],
            
            // More Applications
            ['question' => 'What should I ask for in a recommendation letter?', 'answer' => 'Ask politely and provide your recommender with your CV and details about the scholarship.', 'category' => 'Applications'],
            ['question' => 'When are scholarship deadlines?', 'answer' => 'Deadlines vary year-round. Check each scholarship listing for its specific deadline.', 'category' => 'Applications'],
            ['question' => 'What happens after I apply?', 'answer' => 'The scholarship committee reviews applications. Notification timelines vary from weeks to months.', 'category' => 'Applications'],
            
            // Interviews
            ['question' => 'Do all scholarships require interviews?', 'answer' => 'No, but some competitive ones do. Prepare by practicing common interview questions.', 'category' => 'Interviews'],
            ['question' => 'How should I dress for a scholarship interview?', 'answer' => 'Business casual or professional attire is recommended.', 'category' => 'Interviews'],

            // Tips
            ['question' => 'How can I increase my chances?', 'answer' => 'Apply early, tailor your essays, and ensure you meet all eligibility criteria.', 'category' => 'Tips'],
            ['question' => 'Where can I find local scholarships?', 'answer' => 'Check with your school counselor, local community organizations, and libraries.', 'category' => 'Tips'],
            ['question' => 'How to spot a scholarship scam?', 'answer' => 'Never pay to apply for a scholarship. Legitimate scholarships do not ask for application fees.', 'category' => 'Tips'],
            
            // Platform
            ['question' => 'How often is the site updated?', 'answer' => 'We update our database daily with new opportunities.', 'category' => 'Platform'],
            ['question' => 'Can I suggest a scholarship?', 'answer' => 'Yes, please contact us with the details and we will review it.', 'category' => 'Platform'],
            ['question' => 'Is there a mobile app?', 'answer' => 'We have a mobile-responsive website that works great on all devices.', 'category' => 'Platform'],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::create(array_merge($faq, ['sort_order' => $index]));
        }
    }
}
