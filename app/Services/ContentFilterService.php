<?php

namespace App\Services;

class ContentFilterService
{
    private $badWords = [
        // كلمات عربية غير لائقة
        'كس', 'شرموطة', 'عاهرة', 'زانية', 'قحبة', 'يلعن', 'انيك', 'نيك', 'طيز', 'خرا', 
        'قحبة', 'دعارة', 'زبالة', 'كلب', 'حمار', 'عير', 'فحل', 'زق', 'طاق', 'كسم', 'كحبة',
        'ايري', 'بكسها', 'تبعها', 'حطو بيها', 'يلعن تبعها', 'كس امك', 'انيكك', 'يلعن خرقها',
        
        // كلمات إنجليزية غير لائقة
        'fuck', 'shit', 'bitch', 'asshole', 'motherfucker', 'dick', 'pussy', 'cunt',
        'whore', 'slut', 'bastard', 'damn', 'hell', 'cock', 'piss', 'fag', 'faggot',
        
        // كلمات تركية غير لائقة
        'siktir', 'amk', 'aq', 'orospu', 'piç', 'göt', 'sik', 'kahpe', 'pezevenk'
    ];

    private $warningWords = [
        'غبي', 'احمق', 'تافه', 'فاشل', 'مقرف', 'قذر', 'منحط'
    ];

    public function filterContent($text)
    {
        $originalText = $text;
        $flaggedWords = [];
        $hasBadWords = false;
        $hasWarningWords = false;

        // تحويل النص إلى حروف صغيرة للبحث
        $lowerText = mb_strtolower($text, 'UTF-8');

        // البحث عن الكلمات السيئة
        foreach ($this->badWords as $word) {
            if (str_contains($lowerText, $word)) {
                $hasBadWords = true;
                $flaggedWords[] = $word;
                // استبدال الكلمة بـ ***
                $text = $this->replaceWord($text, $word);
            }
        }

        // البحث عن كلمات التحذير
        foreach ($this->warningWords as $word) {
            if (str_contains($lowerText, $word)) {
                $hasWarningWords = true;
                $flaggedWords[] = $word;
            }
        }

        return [
            'filtered_text' => $text,
            'has_bad_words' => $hasBadWords,
            'has_warning_words' => $hasWarningWords,
            'flagged_words' => $flaggedWords,
            'is_clean' => !$hasBadWords && !$hasWarningWords,
            'needs_moderation' => $hasBadWords || $hasWarningWords
        ];
    }

    private function replaceWord($text, $word)
    {
        // استبدال الكلمة مع الحفاظ على الحالة (كبير/صغير)
        $pattern = '/\b' . preg_quote($word, '/') . '\b/iu';
        return preg_replace($pattern, '***', $text);
    }

    public function addBadWord($word)
    {
        if (!in_array($word, $this->badWords)) {
            $this->badWords[] = $word;
        }
    }

    public function addWarningWord($word)
    {
        if (!in_array($word, $this->warningWords)) {
            $this->warningWords[] = $word;
        }
    }

    public function getBadWordsList()
    {
        return $this->badWords;
    }

    public function getWarningWordsList()
    {
        return $this->warningWords;
    }
}
