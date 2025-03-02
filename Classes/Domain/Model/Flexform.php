<?php

namespace FelixNagel\Beautyofcode\Domain\Model;

/**
 * This file is part of the "beautyofcode" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\Beautyofcode\Highlighter\ConfigurationInterface;

/**
 * Domain model object for the flexform configuration of a plugin instance.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Flexform extends \TYPO3\CMS\Extbase\DomainObject\AbstractValueObject
{
    /**
     * ConfigurationInterface.
     *
     * @var \FelixNagel\Beautyofcode\Highlighter\ConfigurationInterface
     */
    protected $highlighterConfiguration;

    /**
     * Code label.
     *
     * @var string
     */
    protected $cLabel;

    /**
     * Code language / brush.
     *
     * @var string
     */
    protected $cLang;

    /**
     * Code URL / File
     *
     * @var string
     */
    protected $cFile;

    /**
     * Code highlight lines.
     *
     * @var string
     */
    protected $cHighlight;

    /**
     * Code block collapse flag.
     *
     * @var string
     */
    protected $cCollapse;

    /**
     * Code block show gutter flag.
     *
     * @var string
     */
    protected $cGutter;

    /**
     * Default settings from settings.defaults.
     *
     * @var array
     */
    protected $typoscriptDefaults = [];

    /**
     * Language / brush fallback.
     *
     * @var string
     */
    protected $languageFallback = 'plain';

    /**
     * Initialize object from the flexForm datas
     *
     * @param array $flexformValues parsed values
     * sample :
     * cLabel:""
     * cLang:"cpp"
     * cHighlight:""
     * cCollapse:"auto"
     * cGutter:"auto"
     */
    public function initializeObject(array $flexformValues = [])
    {
        $this->cLabel = $flexformValues['cLabel'] ?? $this->cLabel;
        $this->cLang = $flexformValues['cLang'] ?? $this->cLang;
        $this->cFile = $flexformValues['cFile'] ?? $this->cFile;
        $this->cHighlight = $flexformValues['cHighlight'] ?? $this->cHighlight;
        $this->cCollapse = $flexformValues['cCollapse'] ?? $this->cCollapse;
        $this->cGutter = $flexformValues['cGutter'] ?? $this->cGutter;
        $this->languageFallback = $flexformValues['languageFallback'] ?? $this->languageFallback;
    }

    /**
     * InjectHighlighterConfiguration.
     *
     * @param ConfigurationInterface $highlighterConfiguration ConfigurationInterface
     */
    public function injectHighlighterConfiguration(ConfigurationInterface $highlighterConfiguration)
    {
        $this->highlighterConfiguration = $highlighterConfiguration;
    }

    /**
     * SetCLabel.
     *
     * @param string $cLabel The label
     */
    public function setCLabel($cLabel)
    {
        $this->cLabel = $cLabel;
    }

    /**
     * GetCLabel.
     *
     * @return string
     */
    public function getCLabel()
    {
        return $this->cLabel;
    }

    /**
     * SetCLang.
     *
     * @param string $cLang The language / brush
     */
    public function setCLang($cLang)
    {
        $this->cLang = $cLang;
    }

    /**
     * GetCLang.
     *
     * @return string
     */
    public function getCLang()
    {
        return $this->cLang;
    }

    /**
     * @param string $cFile
     */
    public function setCFile($cFile)
    {
        $this->cFile = $cFile;
    }

    /**
     * @return string
     */
    public function getCFile()
    {
        return $this->cFile;
    }

    /**
     * SetCHihglight.
     *
     * @param string $cHighlight The highlight-lines configuration string
     */
    public function setCHighlight($cHighlight)
    {
        $this->cHighlight = $cHighlight;
    }

    /**
     * GetCHighlight.
     *
     * @return string
     */
    public function getCHighlight()
    {
        return $this->cHighlight;
    }

    /**
     * SetCCollapse.
     *
     * @param string $cCollapse The code block collapse flag
     */
    public function setCCollapse($cCollapse)
    {
        $this->cCollapse = $cCollapse;
    }

    /**
     * GetCCollapse.
     *
     * @return string
     */
    public function getCCollapse()
    {
        return $this->cCollapse;
    }

    /**
     * SetCGutter.
     *
     * @param string $cGutter The code block show gutter flag
     */
    public function setCGutter($cGutter)
    {
        $this->cGutter = $cGutter;
    }

    /**
     * GetCGutter.
     *
     * @return string
     */
    public function getCGutter()
    {
        return $this->cGutter;
    }

    /**
     * GetIsGutterActive.
     *
     * @return bool
     */
    public function getIsGutterActive()
    {
        $isOffForInstance = '0' === $this->cGutter;
        $isOnForInstance = '1' === $this->cGutter;
        $useDefault = 'auto' === $this->cGutter;
        $isDefaultSet = isset($this->typoscriptDefaults['gutter']);

        if ($isOffForInstance) {
            return false;
        } elseif ($isOnForInstance) {
            return true;
        } elseif ($useDefault && $isDefaultSet) {
            return (bool) $this->typoscriptDefaults['gutter'];
        }

        return false;
    }

    /**
     * SetTyposcriptDefaults.
     *
     * @param array $typoscriptDefaults TypoScript defaults
     */
    public function setTyposcriptDefaults($typoscriptDefaults = [])
    {
        $this->typoscriptDefaults = $typoscriptDefaults;
    }

    /**
     * GetLanguage.
     *
     * @return string
     */
    public function getLanguage()
    {
        $language = $this->cLang ? $this->cLang : $this->languageFallback;

        return $this->highlighterConfiguration->getFailSafeBrushAlias($language);
    }

    /**
     * GetClassAttributeString.
     *
     * @return string
     */
    public function getClassAttributeString()
    {
        return $this->highlighterConfiguration->getClassAttributeString($this);
    }

    /**
     * Returns an array of brush CSS name + ressource file name.
     *
     * @return array
     */
    public function getAutoloaderBrushMap()
    {
        return $this->highlighterConfiguration->getAutoloaderBrushMap();
    }
}
