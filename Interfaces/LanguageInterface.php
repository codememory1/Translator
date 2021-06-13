<?php

namespace Codememory\Components\Translator\Interfaces;

/**
 * Interface LanguageInterface
 *
 * @package Codememory\Components\Translator\Interfaces
 *
 * @author  Codememory
 */
interface LanguageInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Set the translation language, if this language does not exist,
     * the default language will be selected
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $lang
     *
     * @return LanguageInterface
     */
    public function setLang(string $lang): LanguageInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns an array of all existing languages
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function getAllLang(): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the currently active language
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return string
     */
    public function getActiveLang(): string;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Check the existence of a language
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $lang
     *
     * @return bool
     */
    public function existLang(string $lang): bool;

}