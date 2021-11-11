<?php

/**
 * Customisations for amitys.com
 */

declare(strict_types=1);

namespace AmitysDotCom;

use Fisharebest\Webtrees\Contracts\ElementInterface;
use Fisharebest\Webtrees\Elements\AddressLine;
use Fisharebest\Webtrees\Elements\AddressWebPage;
use Fisharebest\Webtrees\Elements\CustomElement;
use Fisharebest\Webtrees\Elements\CustomFact;
use Fisharebest\Webtrees\Elements\EmptyElement;
use Fisharebest\Webtrees\Elements\NameOfRepository;
use Fisharebest\Webtrees\Elements\SourceDescriptiveTitle;
use Fisharebest\Webtrees\Elements\SubmitterText;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTagsInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTagsTrait;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\View;

return new class() extends AbstractModule implements ModuleCustomTagsInterface, ModuleCustomInterface {
    // For every module interface that is implemented, the corresponding trait should also use be used.
    use ModuleCustomTrait;
    use ModuleCustomTagsTrait { ModuleCustomTagsTrait::boot as public bootTagsTrait; }

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return I18N::translate('amitys.com');
    }

    /**
     * A sentence describing what this module does.
     *
     * @return string
     */
    public function description(): string
    {
        return I18N::translate('Customisations for amitys.com');
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return 'Greg Roach and Meliza Amity';
    }

    /**
     * Where does this module store its resources
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }

    /**
     * Bootstrap the module
     */
    public function boot(): void
    {
        // Register a namespace for our views.
        View::registerNamespace($this->name(), $this->resourcesFolder() . 'views/');

        // Replace an existing view with our own version.
        View::registerCustomView('::lists/datatables-attributes', $this->name() . '::lists/datatables-attributes');

        $this->bootTagsTrait();
    }

    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return array<string>
     */
    public function customTranslations(string $language): array
    {
        switch ($language) {
            case 'da':
                return [
                    'Mother tongue' => 'Modersmål',
                    '%s&nbsp;CE'    => '%s (juliansk)',
                    'Youth'         => 'Ungdom',
                    'Maiden'        => 'Jomfru',
                    'Woman'         => 'Kvinde',
                    'Child'         => 'Barn',
                    'Young'         => 'Unge',
                ];

            case 'en-AU':
            case 'en-GB':
            case 'en-US':
                return [
                    '%s&nbsp;CE' => '%s (julian)',
                ];

            case 'fi':
                return [
                    'Mother tongue' => 'Äidinkieli',
                    '%s&nbsp;CE'    => '%s (juliaani)',
                    'Youth'         => 'Nuorukainen',
                    'Maiden'        => 'Neitsyt',
                    'Woman'         => 'Nainen',
                    'Child'         => 'Lapsi',
                    'Young'         => 'Nuori',
                ];

            case 'fr':
            case 'fr-CA':
                return [
                    'Mother tongue' => 'Langue maternelle',
                ];

            case 'he':
                return [
                    'Mother tongue' => 'שפת אם',
                    '%s&nbsp;CE'    => '%s (יוליאני)',
                    'Youth'         => 'בחור',
                    'Maiden'        => 'בתולה',
                    'Woman'         => 'אשה',
                    'Child'         => 'ילד',
                    'Young'         => 'צעיר',
                ];

            case 'sv':
                return [
                    'Mother tongue' => 'Modersmål',
                    '%s&nbsp;CE'    => '%s (juliansk)',
                    'Youth'         => 'Yngling',
                    'Maiden'        => 'Jungfru',
                    'Woman'         => 'Kvinna',
                    'Child'         => 'Barn',
                    'Young'         => 'Yngling',
                ];

            default:
                return [];
        }
    }

    /**
     * Add new (or replace existing) tags in the GEDCOM structure.
     * Each element type has a default set of sub-tags.
     * If these sub-tags are not correct in this context, we can set our own.
     *
     * @return array<string,ElementInterface>
     */
    public function customTags(): array
    {
        return [
            'FAM:DATA'       => new EmptyElement(I18N::translate('Data'), ['TEXT' => '1:1']),
            'FAM:DATA:TEXT'  => new SubmitterText(I18N::translate('Text')),
            'FAM:_NMR'       => new CustomFact(I18N::translate('Not married'), ['NOTE' => '0:M', 'SOUR' => '0:M']),
            'INDI:ADDR'      => new AddressLine(I18N::translate('Address')),
            'INDI:ADDR:URL'  => new AddressWebPage(I18N::translate('URL')),
            'INDI:COMM'      => new CustomElement(I18N::translate('Comment'), ['URL' => '0:1']),
            'INDI:COMM:URL'  => new AddressWebPage(I18N::translate('URL')),
            'INDI:DATA'      => new EmptyElement(I18N::translate('Data'), ['TEXT' => '1:1']),
            'INDI:DATA:TEXT' => new SubmitterText(I18N::translate('Text')),
            'INDI:WWW'       => new AddressWebPage(I18N::translate('URL')),
            'INDI:_DNA'      => new CustomFact(I18N::translate('DNA markers')),
            'INDI:_HNM'      => new CustomElement(I18N::translate('Hebrew name')),
            'INDI:_MTNG'     => new CustomElement(I18N::translate('Mother tongue')),
            'REPO:NAME:_HEB' => new NameOfRepository(I18N::translate('Name in Hebrew')),
            'SOUR:AUTH:NOTE' => new SubmitterText(I18N::translate('Note')),
            'SOUR:TITL:_HEB' => new SourceDescriptiveTitle(I18N::translate('Name in Hebrew')),
        ];
    }

    /**
     * Add/update/remove sub-tags from existing GEDCOM structures.
     * This allows us to add new instances of the elements defined in customTags().
     *
     * @return array<string,array<int,array<int,string>>>
     */
    public function customSubTags(): array
    {
        return [
            'FAM'       => [
                ['DATA', '0:M'],
                ['_NMR', '0:1'],
            ],
            'INDI'      => [
                ['ADDR', '0:M'],
                ['COMM', '0:M'],
                ['DATA', '0:M'],
                ['WWW', '0:M'],
                ['_DNA', '0:M'],
                ['_HNM', '0:M'],
                ['_MTNG', '0:M'],
            ],
            'REPO:NAME' => [
                ['_HEB', '0:1']
            ],
            'SOUR:AUTH' => [
                ['NOTE', '0:M']
            ],
            'SOUR:TITL' => [
                ['_HEB', '0:1']
            ],
        ];
    }
};

