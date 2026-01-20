<?php

namespace App\Enums;

enum ResourceCategory: string
{
    case SCHOLARSHIP = 'scholarship';
    case ESSAY = 'essay';
    case FINANCIAL_AID = 'financial-aid';
    case STUDY_ABROAD = 'study-abroad';
    case CAREER = 'career';

    public function label(): string
    {
        return match ($this) {
            self::SCHOLARSHIP => 'Scholarship',
            self::ESSAY => 'Essay Writing',
            self::FINANCIAL_AID => 'Financial Aid',
            self::STUDY_ABROAD => 'Study Abroad',
            self::CAREER => 'Career Development',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::SCHOLARSHIP => 'academic-cap-02',
            self::ESSAY => 'pencil-01',
            self::FINANCIAL_AID => 'coins-01',
            self::STUDY_ABROAD => 'globe-02',
            self::CAREER => 'briefcase-01',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SCHOLARSHIP => 'primary',
            self::ESSAY => 'success',
            self::FINANCIAL_AID => 'warning',
            self::STUDY_ABROAD => 'info',
            self::CAREER => 'danger',
        };
    }
}
