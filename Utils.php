<?php

namespace Codememory\Components\Translator;

use Codememory\Components\Configuration\Config;
use Codememory\Components\Configuration\Exceptions\ConfigNotFoundException;
use Codememory\Components\Configuration\Interfaces\ConfigInterface;
use Codememory\Components\Environment\Exceptions\EnvironmentVariableNotFoundException;
use Codememory\Components\Environment\Exceptions\IncorrectPathToEnviException;
use Codememory\Components\Environment\Exceptions\ParsingErrorException;
use Codememory\Components\Environment\Exceptions\VariableParsingErrorException;
use Codememory\Components\GlobalConfig\GlobalConfig;
use Codememory\FileSystem\File;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class Utils
 *
 * @package Codememory\Components\Translator
 *
 * @author  Codememory
 */
class Utils
{

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Utils constructor.
     *
     * @throws ConfigNotFoundException
     * @throws EnvironmentVariableNotFoundException
     * @throws IncorrectPathToEnviException
     * @throws ParsingErrorException
     * @throws VariableParsingErrorException
     */
    public function __construct()
    {

        $config = new Config(new File());

        $this->config = $config->open(GlobalConfig::get('translation.configName'), $this->getDefaultConfig());

    }

    /**
     * @return string
     */
    public function getDefaultLanguage(): string
    {

        return $this->config->get('defaultLanguage');

    }

    /**
     * @return string
     */
    public function getPathWithTranslations(): string
    {

        return $this->config->get('pathWithTranslations');

    }

    /**
     * @return array
     */
    #[ArrayShape(['defaultLanguage' => "mixed", 'pathWithTranslations' => "mixed"])]
    private function getDefaultConfig(): array
    {

        return [
            'defaultLanguage'      => GlobalConfig::get('translation.defaultLanguage'),
            'pathWithTranslations' => GlobalConfig::get('translation.pathWithTranslations'),
        ];

    }

}