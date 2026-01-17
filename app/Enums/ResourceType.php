<?php

namespace App\Enums;

enum ResourceType: string
{
    case GUIDE = 'guide';
    case TEMPLATE = 'template';
    case CHECKLIST = 'checklist';
    case VIDEO = 'video';
    case ARTICLE = 'article';
    case TOOL = 'tool';
    case EXTERNAL_LINK = 'external_link';

    public function label(): string
    {
        return match ($this) {
            self::GUIDE => 'Guide',
            self::TEMPLATE => 'Template',
            self::CHECKLIST => 'Checklist',
            self::VIDEO => 'Video',
            self::ARTICLE => 'Article',
            self::TOOL => 'Tool',
            self::EXTERNAL_LINK => 'External Link',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::GUIDE => 'book-02',
            self::TEMPLATE => 'file-02',
            self::CHECKLIST => 'checkbox-check',
            self::VIDEO => 'video-01',
            self::ARTICLE => 'note',
            self::TOOL => 'settings-01',
            self::EXTERNAL_LINK => 'link-01',
        };
    }
}
