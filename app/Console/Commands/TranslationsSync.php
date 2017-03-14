<?php

namespace App\Console\Commands;

use App\Miscellaneous\PrettyPrinterStandard;
use Illuminate\Console\Command;
use PhpParser\Comment;
use PhpParser\Error;
use PhpParser\ParserFactory;

class TranslationsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize translation files based on default locale';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $default = config('app.locale');
        if (($key = array_search($default, $locales)) !== false) {
            unset($locales[$key]);
        }

        $defaultTranslations = $this->getTranslations($default);

        $otherTranslations = $this->getTranslationsForLocales($locales);

        $missingTranslations = $this->findMissingTranslations($defaultTranslations, $otherTranslations);

        //$this->parseFile(resource_path('lang/en/auth.php'));

        dd($missingTranslations);

    }

    /**
     * Parse PHP file
     *
     * @param $file
     */
    protected function parseFile($file)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $prettyPrinter = new PrettyPrinterStandard;

        $code = file_get_contents($file);

        try {
            $stmts = $parser->parse($code);

            dump($stmts[0]->expr->items);

            $stmts[0]->expr->items[1]->setAttribute('comments', [
                new Comment("// test")
            ]);

            $code = $prettyPrinter->prettyPrintFile($stmts);

            echo $code;
            die();
            // $stmts is an array of statement nodes
        } catch (Error $e) {
            echo 'Parse Error: ', $e->getMessage();
        }
    }

    /**
     * Find missing translations
     *
     * @param $default
     * @param $other
     * @return array
     */
    protected function findMissingTranslations($default, $other)
    {
        $missing = [];
        foreach ($other as $lang => $translation) {
            $missing[$lang] = array_diff_multi($default, $translation);
        }

        return $missing;
    }

    /**
     * Get all translations for array of locales
     *
     * @param $locales
     * @return array
     */
    protected function getTranslationsForLocales($locales)
    {
        $translations = [];
        foreach ($locales as $locale) {
            $translations[$locale] = $this->getTranslations($locale);
        }

        return $translations;
    }

    /**
     * Get all translations for locale
     *
     * @param $locale
     * @return array
     */
    protected function getTranslations($locale)
    {
        $translations = [];

        foreach (new \DirectoryIterator(resource_path('lang/' . $locale)) as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isDot()) {
                continue;
            }
            $translations[$file->getBasename('.php')] = include $file->getPathname();
        }

        return $translations;
    }
}
