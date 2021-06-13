<?php

namespace Codememory\Components\Translator;

use Codememory\Components\Caching\Cache;
use Codememory\Components\Caching\Exceptions\ConfigPathNotExistException;
use Codememory\Components\Markup\Types\YamlType;
use Codememory\Components\Translator\Interfaces\TranslationInterface;
use Codememory\FileSystem\File;
use Codememory\FileSystem\Interfaces\FileInterface;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use Codememory\Support\Arr;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Translation
 *
 * @package Codememory\Components\Translator
 *
 * @author  Codememory
 */
class Translation implements TranslationInterface
{

    public const TYPE_CACHE = '_cdm-translations';
    public const NAME_CACHE = 'translations';

    /**
     * @var Language
     */
    public Language $language;

    /**
     * @var FileInterface
     */
    private FileInterface $filesystem;

    /**
     * @var Utils
     */
    private Utils $utils;

    /**
     * @var array
     */
    private array $langWithTranslations;

    /**
     * Translation constructor.
     *
     * @param RequestInterface $request
     *
     * @throws ConfigPathNotExistException
     */
    public function __construct(RequestInterface $request)
    {

        $this->filesystem = new File();
        $this->utils = new Utils();
        $this->language = new Language($request, $this->utils, $this->filesystem);

        $this->langWithTranslations = $this->processReceivingTransfers();

    }

    /**
     * @inheritDoc
     */
    public function addTranslation(string $key, string $value, ?string $lang = null): TranslationInterface
    {

        if ($this->language->existLang($lang)) {
            $this->langWithTranslations[$lang][$key] = $value;
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function getTranslationActiveLang(string $key, ?string $default = null): ?string
    {

        $translations = $this->getAllTranslationsActiveLang();

        return Arr::set($translations)::get($key) ?: $default;

    }

    /**
     * @inheritDoc
     */
    public function getTranslationByLang(string $key, string $lang, ?string $default = null): ?string
    {

        $translations = $this->getAllTranslationsByLang($lang);

        return Arr::set($translations)::get($key) ?: $default;

    }

    /**
     * @inheritDoc
     */
    public function getAllTranslationsActiveLang(): array
    {

        $activeLang = $this->language->getActiveLang();

        if ($this->language->existLang($activeLang)) {
            return $this->langWithTranslations[$activeLang];
        }

        return $this->langWithTranslations[$this->utils->getDefaultLanguage()];

    }

    /**
     * @inheritDoc
     */
    public function getAllTranslationsByLang(string $lang): array
    {

        $translations = Yaml::parseFile($this->composePathToLangTranslations($lang));

        if (false === is_array($translations)) {
            return [];
        }

        return $translations;

    }

    /**
     * @param string $lang
     *
     * @return string
     */
    private function composePathToLangTranslations(string $lang): string
    {

        return sprintf('%s/%s.yaml', $this->filesystem->getRealPath($this->utils->getPathWithTranslations()), $lang);

    }

    /**
     * @return array
     * @throws ConfigPathNotExistException
     */
    private function processReceivingTransfers(): array
    {

        $langWithTranslations = [];
        $caching = new Cache(new YamlType(), $this->filesystem);

        if (isDev()) {
            foreach ($this->language->getAllLang() as $lang) {
                $langWithTranslations[$lang] = $this->getAllTranslationsByLang($lang);
            }
        } else {
            $langWithTranslations = $caching->get(self::TYPE_CACHE, self::NAME_CACHE);
        }

        return $langWithTranslations;

    }

}
