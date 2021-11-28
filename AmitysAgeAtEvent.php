<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2021 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace AmitysDotCom;

use Fisharebest\Webtrees\Elements\AgeAtEvent;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Tree;

/**
 * Modified version of AgeAtEvent, with additional keywords
 */
class AmitysAgeAtEvent extends AgeAtEvent
{
    protected const KEYWORDS = ['YOUTH', 'MAIDEN', 'WOMAN', 'YOUNG'] + parent::KEYWORDS;

    /**
     * Display the value of this type of element.
     *
     * @param string $value
     * @param Tree   $tree
     *
     * @return string
     */
    public function value(string $value, Tree $tree): string
    {
        $canonical = $this->canonical($value);

        switch ($canonical) {
            case 'YOUTH':
                return I18N::translate('Youth');

            case 'MAIDEN':
                return I18N::translate('Maiden');

            case 'WOMAN':
                return I18N::translate('Woman');

            case 'YOUNG':
                return I18N::translate('Young');
        }

        return parent::value($value, $tree);
    }
}
