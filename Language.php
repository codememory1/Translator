<?php

namespace Codememory\Components\Translator;

use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\Finder\Find;
use Codememory\Components\Finder\FinderInterface;
use Codememory\Components\Translator\Interfaces\LanguageInterface;
use Codememory\FileSystem\Interfaces\FileInterface;
use Codememory\HttpFoundation\Exceptions\InvalidCookieNameException;
use Codememory\HttpFoundation\Exceptions\InvalidSameSiteException;
use Codememory\HttpFoundation\Exceptions\NotSpecifiedSecureException;
use Codememory\HttpFoundation\Interfaces\RequestInterface;
use Codememory\Support\Arr;
use Codememory\Support\Str;

/**
 * Class Language
 *
 * @package Codememory\Components\Translator
 *
 * @author  Codememory
 */
class Language implements LanguageInterface
{

    private const COOKIE_NAME = '_lang';

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var Utils
     */
    private Utils $utils;

    /**
     * @var FileInterface
     */
    private FileInterface $filesystem;

    /**
     * @var FinderInterface
     */
    private FinderInterface $finder;

    /**
     * @var string
     */
    private string $activeLang;

    /**
     * Language constructor.
     *
     * @param RequestInterface $request
     * @param Utils            $utils
     * @param FileInterface    $filesystem
     */
    public function __construct(RequestInterface $request, Utils $utils, FileInterface $filesystem)
    {

        $this->request = $request;
        $this->utils = $utils;
        $this->filesystem = $filesystem;
        $this->finder = new Find();
        $this->activeLang = $this->activeLangDetection();

    }

    /**
     * @inheritDoc
     * @throws InvalidTimezoneException
     * @throws InvalidCookieNameException
     * @throws InvalidSameSiteException
     * @throws NotSpecifiedSecureException
     */
    public function setLang(string $lang): LanguageInterface
    {

        $this->request->cookie->create(self::COOKIE_NAME, Str::toLowercase($lang));

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function getAllLang(): array
    {

        $filesWithTranslations =
            $this->finder->setPathForFind($this->utils->getPathWithTranslations())
                ->file()
                ->expansion('yaml')
                ->get();

        Arr::map($filesWithTranslations, function (int $key, ?string $value) {
            $filenameWithExtension = $this->filesystem->basename($value);

            return [Str::trimAfterSymbol($filenameWithExtension, '.yaml')];
        });

        return $filesWithTranslations;

    }

    /**
     * @inheritDoc
     */
    public function getActiveLang(): string
    {

        return $this->activeLang;

    }

    /**
     * @inheritDoc
     */
    public function existLang(string $lang): bool
    {

        return in_array(Str::toLowercase($lang), $this->getAllLang());

    }

    /**
     * @return string
     */
    private function activeLangDetection(): string
    {

        return Str::toLowercase($this->request->cookie->get(self::COOKIE_NAME) ?: $this->utils->getDefaultLanguage());

    }

}