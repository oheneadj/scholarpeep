<?php

namespace App\Services;

use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Support\Collection;

class ScholarshipMatcher
{
    /**
     * Get personalized scholarship recommendations for a user
     *
     * @param User $user
     * @param int $limit
     * @return Collection
     */
    public function getRecommendations(User $user, int $limit = 10): Collection
    {
        if (!$this->userHasProfile($user)) {
            return collect();
        }

        $scholarships = Scholarship::with(['countries', 'educationLevels', 'fieldsOfStudy'])
            ->where('is_active', true)
            ->get();

        $scoredScholarships = $scholarships->map(function ($scholarship) use ($user) {
            return [
                'scholarship' => $scholarship,
                'score' => $this->calculateMatchScore($user, $scholarship),
            ];
        });

        return $scoredScholarships
            ->filter(fn($item) => $item['score'] > 0)
            ->sortByDesc('score')
            ->take($limit)
            ->pluck('scholarship');
    }

    /**
     * Calculate match score between user and scholarship (0-100)
     *
     * @param User $user
     * @param Scholarship $scholarship
     * @return int
     */
    public function calculateMatchScore(User $user, Scholarship $scholarship): int
    {
        $score = 0;
        $maxScore = 0;

        // Education Level Match (30 points)
        $maxScore += 30;
        if ($user->education_level_id && $scholarship->educationLevels->contains('id', $user->education_level_id)) {
            $score += 30;
        }

        // Field of Study Match (30 points)
        $maxScore += 30;
        if ($user->field_of_study_id && $scholarship->fieldsOfStudy->contains('id', $user->field_of_study_id)) {
            $score += 30;
        }

        // Country Match (25 points)
        $maxScore += 25;
        if ($user->country_id && $scholarship->countries->contains('id', $user->country_id)) {
            $score += 25;
        }

        // GPA Requirement Match (15 points)
        $maxScore += 15;
        if ($user->gpa) {
            if (!$scholarship->min_gpa || $user->gpa >= $scholarship->min_gpa) {
                $score += 15;
            }
        }

        // Normalize to 0-100 scale
        return $maxScore > 0 ? (int) round(($score / $maxScore) * 100) : 0;
    }

    /**
     * Check if user has completed their profile
     *
     * @param User $user
     * @return bool
     */
    public function userHasProfile(User $user): bool
    {
        return $user->education_level_id !== null 
            || $user->field_of_study_id !== null 
            || $user->country_id !== null;
    }

    /**
     * Get match score label
     *
     * @param int $score
     * @return string
     */
    public function getMatchLabel(int $score): string
    {
        return match (true) {
            $score >= 80 => 'Excellent Match',
            $score >= 60 => 'Good Match',
            $score >= 40 => 'Fair Match',
            $score > 0 => 'Possible Match',
            default => 'No Match',
        };
    }

    /**
     * Get match score color class
     *
     * @param int $score
     * @return string
     */
    public function getMatchColorClass(int $score): string
    {
        return match (true) {
            $score >= 80 => 'text-emerald-600 bg-emerald-50',
            $score >= 60 => 'text-blue-600 bg-blue-50',
            $score >= 40 => 'text-amber-600 bg-amber-50',
            $score > 0 => 'text-gray-600 bg-gray-50',
            default => 'text-gray-400 bg-gray-50',
        };
    }
}
