<?php

namespace Codememory\Components\Translator\Interfaces;

/**
 * Interface TranslationInterface
 *
 * @package Codememory\Components\Translator\Interfaces
 *
 * @author  Codememory
 */
interface TranslationInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add dynamically a new translation to any language
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string      $key
     * @param string      $value
     * @param string|null $lang
     *
     * @return TranslationInterface
     */
    public function addTranslation(string $key, string $value, ?string $lang = null): TranslationInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get translation by active language key
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string      $key
     * @param string|null $default
     *
     * @return string|null
     */
    public function getTranslationActiveLang(string $key, ?string $default = null): ?string;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get a translation by key from a specific language
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string      $key
     * @param string      $lang
     * @param string|null $default
     *
     * @return string|null
     */
    public function getTranslationByLang(string $key, string $lang, ?string $default = null): ?string;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of all translations of the active language
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function getAllTranslationsActiveLang(): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get all translations of a specific language
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $lang
     *
     * @return array
     */
    public function getAllTranslationsByLang(string $lang): array;

}