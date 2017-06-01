<?php
/**
 * Created by PhpStorm.
 * User: AntonDachauer
 * Date: 01.06.2017
 * Time: 15:47
 */

namespace FlowFusion\BlogBundle\Service;

use Cocur\Slugify\Slugify;

/**
 * Class SlugifyService
 * @package FlowFusion\BlogBundle\Service
 */
class SlugifyService
{

    private $locale;

    private $language_mapping = [
        'de' => 'german',
        'de_DE' => 'germna',
        'en' => 'english',
    ];

    /**
     * SlugifyService constructor.
     * @param $locale
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @param $locale
     * @return mixed|string
     */
    public function getRuleName($locale)
    {
        return isset($this->language_mapping[$locale]) ? $this->language_mapping[$locale] : 'english';
    }

    /**
     * @param $value
     * @return string
     */
    public function slugify($value)
    {
        $slugify = new Slugify();
        $slugify->activateRuleSet($this->getRuleName($this->locale));

        return $slugify->slugify($value);
    }

}
