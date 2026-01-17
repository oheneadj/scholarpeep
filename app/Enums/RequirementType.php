<?php

namespace App\Enums;

enum RequirementType: string
{
    case DOCUMENT = 'document';
    case ESSAY = 'essay';
    case RECOMMENDATION_LETTER = 'recommendation_letter';
    case TRANSCRIPT = 'transcript';
    case TEST_SCORE = 'test_score';
    case PORTFOLIO = 'portfolio';
    case INTERVIEW = 'interview';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::DOCUMENT => 'Document',
            self::ESSAY => 'Essay',
            self::RECOMMENDATION_LETTER => 'Recommendation Letter',
            self::TRANSCRIPT => 'Transcript',
            self::TEST_SCORE => 'Test Score',
            self::PORTFOLIO => 'Portfolio',
            self::INTERVIEW => 'Interview',
            self::OTHER => 'Other',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::DOCUMENT => 'file-02',
            self::ESSAY => 'note-edit',
            self::RECOMMENDATION_LETTER => 'mail-01',
            self::TRANSCRIPT => 'file-validation',
            self::TEST_SCORE => 'clipboard',
            self::PORTFOLIO => 'folder-02',
            self::INTERVIEW => 'user-multiple',
            self::OTHER => 'more-horizontal',
        };
    }
}
