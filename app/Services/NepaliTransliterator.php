<?php

namespace App\Services;

/**
 * Turns a romanized Nepali search term into a Devanagari regular expression,
 * so typing "sifaris" finds सिफारिस.
 *
 * Casual romanization is lossy — "a" stands for both अ and आ, "t" for both त
 * and ट — so a single transliteration would rarely match. Instead every
 * ambiguous sound becomes a character class and the inherent vowel becomes
 * optional, which trades a little precision for the recall a search box wants.
 */
class NepaliTransliterator
{
    /**
     * Romanized consonant → the Devanagari letters it might stand for.
     * Longer keys are matched first, so "chh" wins over "ch" over "c".
     */
    protected $consonants = [
        'ksh' => 'क्ष',
        'chh' => 'छ',
        'shh' => 'ष',
        'kh' => 'ख',
        'gh' => 'घ',
        'ng' => 'ङ',
        'ch' => 'च',
        'jh' => 'झ',
        'ny' => 'ञ',
        'th' => '[थठ]',
        'dh' => '[धढ]',
        'ph' => 'फ',
        'bh' => 'भ',
        'sh' => '[शष]',
        'gy' => 'ज्ञ',
        'tr' => 'त्र',
        'k' => 'क',
        'g' => 'ग',
        'c' => 'च',
        'j' => 'ज',
        'z' => 'ज',
        't' => '[तट]',
        'd' => '[दड]',
        'n' => '[नणं]',
        'p' => 'प',
        'f' => 'फ',
        'b' => 'ब',
        'm' => 'म',
        'y' => 'य',
        'r' => 'र',
        'l' => 'ल',
        'w' => 'व',
        'v' => 'व',
        's' => '[सशष]',
        'h' => 'ह',
        'x' => 'क्स',
    ];

    /** Romanized vowel → [independent form, matra]. */
    protected $vowels = [
        'aa' => ['आ', 'ा'],
        'ai' => ['ऐ', 'ै'],
        'au' => ['औ', 'ौ'],
        'ee' => ['ई', 'ी'],
        'ii' => ['ई', 'ी'],
        'oo' => ['ऊ', 'ू'],
        'uu' => ['ऊ', 'ू'],
        // Bare "a" is the inherent vowel: it may be written as ा or not at all.
        'a' => ['[अआ]', 'ा?'],
        'i' => ['[इई]', '[िी]'],
        'u' => ['[उऊ]', '[ुू]'],
        'e' => ['ए', 'े'],
        'o' => ['ओ', 'ो'],
    ];

    /** True when the term is already Nepali and needs no transliteration. */
    public function isDevanagari($term)
    {
        return (bool) preg_match('/\p{Devanagari}/u', $term);
    }

    /**
     * Build the Devanagari pattern for a romanized term, or null when the term
     * isn't plain latin text (nothing to transliterate).
     */
    public function toRegex($term)
    {
        $term = mb_strtolower(trim($term));

        if ($term === '' || ! preg_match('/^[a-z0-9 \-]+$/', $term)) {
            return null;
        }

        $consonantKeys = array_keys($this->consonants);
        $vowelKeys = array_keys($this->vowels);
        // Longest first, so multi-letter sounds aren't split apart.
        usort($consonantKeys, fn ($a, $b) => strlen($b) - strlen($a));
        usort($vowelKeys, fn ($a, $b) => strlen($b) - strlen($a));

        $out = '';
        $length = strlen($term);
        $i = 0;

        while ($i < $length) {
            if ($term[$i] === ' ' || $term[$i] === '-') {
                $out .= '\\s+';
                $i++;
                continue;
            }

            $consonant = $this->matchKey($term, $i, $consonantKeys);

            if ($consonant !== null) {
                // The halanta is optional: it is present mid-cluster, absent
                // when a vowel sign follows or the syllable ends a word.
                $out .= $this->consonants[$consonant].'्?';
                $i += strlen($consonant);

                $vowel = $this->matchKey($term, $i, $vowelKeys);

                if ($vowel !== null) {
                    $out .= $this->vowels[$vowel][1];
                    $i += strlen($vowel);
                }

                continue;
            }

            $vowel = $this->matchKey($term, $i, $vowelKeys);

            if ($vowel !== null) {
                $out .= $this->vowels[$vowel][0];
                $i += strlen($vowel);
                continue;
            }

            // Digits and anything unmapped pass through as themselves.
            $out .= preg_quote($term[$i], '/');
            $i++;
        }

        return $out === '' ? null : $out;
    }

    /** The longest key in $keys that $term starts with at $offset. */
    protected function matchKey($term, $offset, array $keys)
    {
        foreach ($keys as $key) {
            if (substr($term, $offset, strlen($key)) === $key) {
                return $key;
            }
        }

        return null;
    }
}
