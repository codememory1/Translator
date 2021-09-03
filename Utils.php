<?php

namespace Codememory\Components\Translator;

use Codememory\Components\Configuration\Configuration;
use Codememory\Components\Configuration\Interfaces\ConfigInterface;
use Codememory\Components\GlobalConfig\GlobalConfig;
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
     */
    public function __construct()
    {

        $this->config = Configuration::getInstance()->open(GlobalConfig::get('translation.configName'), $this->getDefaultConfig());

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