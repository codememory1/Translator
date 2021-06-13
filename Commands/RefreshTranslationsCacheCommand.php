<?php

namespace Codememory\Components\Translator\Commands;

use Codememory\Components\Caching\Cache;
use Codememory\Components\Caching\Exceptions\ConfigPathNotExistException;
use Codememory\Components\Console\Command;
use Codememory\Components\Markup\Types\YamlType;
use Codememory\Components\Translator\Translation;
use Codememory\Components\Translator\Utils;
use Codememory\FileSystem\File;
use Codememory\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class UpdateCacheCommand
 *
 * @package Codememory\Components\Translator\Commands
 *
 * @author  Codememory
 */
class RefreshTranslationsCacheCommand extends Command
{

    /**
     * @var string|null
     */
    protected ?string $command = 'cache:update:translation';

    /**
     * @var string|null
     */
    protected ?string $description = 'Update cache translation of all existing languages';

    /**
     * @inheritDoc
     * @throws ConfigPathNotExistException
     */
    protected function handler(InputInterface $input, OutputInterface $output): int
    {

        $filesystem = new File();
        $utils = new Utils();
        $caching = new Cache(new YamlType(), $filesystem);

        $langWithTranslations = [];

        foreach ($filesystem->scanning($utils->getPathWithTranslations()) as $pathToLang) {
            $lang = Str::trimAfterSymbol($filesystem->basename($pathToLang), '.yaml');
            $fullPathToLang = trim($utils->getPathWithTranslations(), '/') . '/' . $pathToLang;

            $langWithTranslations[$lang] = Yaml::parseFile($filesystem->getRealPath($fullPathToLang));
        }

        $caching->create(Translation::TYPE_CACHE, Translation::NAME_CACHE, $langWithTranslations);

        $this->io->success('Language translation cache has been successfully updated');

        return Command::SUCCESS;

    }

}