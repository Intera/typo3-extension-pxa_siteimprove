<?php

namespace Pixelant\PxaSiteimprove\Tests\Unit\Hooks;

use Pixelant\PxaSiteimprove\Hooks\DeepLinkingHandler;
use Pixelant\PxaSiteimprove\Hooks\PageRenderer;
use Pixelant\PxaSiteimprove\TestCase\UnitTestCase;
use Pixelant\PxaSiteimprove\Utility\CompatibilityUtility;
use TYPO3\CMS\Backend\Controller\BackendController;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

class PageRendererTest extends UnitTestCase
{
    /**
     * @var PageRenderer
     */
    protected $subject;

    /**
     * Setup method
     */
    protected function setUp()
    {
        parent::setUp();

        $this->subject = new PageRenderer();
    }


    /**
     * @test
     */
    public function addResourcesCorrectly()
    {
        $backendUserAuthentication = $this->createCompatibleMock(BackendUserAuthentication::class);
        $GLOBALS['BE_USER'] = $backendUserAuthentication;

        $GLOBALS['BE_USER']->uc = ['use_siteimprove' => 1];
        $GLOBALS['BE_USER']->method('getTSConfigVal')->willReturn(0);
        $GLOBALS['BE_USER']->method('getTSConfig')->willReturn(
            ['options.' => ['siteImprove.' => ['disable' => 0]]]
        );

        $pageRenderer = $this->createCompatibleMock(\TYPO3\CMS\Core\Page\PageRenderer::class);

        $this->subject->addResources(
            [],
            $pageRenderer
        );
    }

    /**
     * @test
     */
    public function addResourcesCorrectlyIfDisabledInTSConfig()
    {
        $backendUserAuthentication = $this->createCompatibleMock(BackendUserAuthentication::class);
        $GLOBALS['BE_USER'] = $backendUserAuthentication;

        $GLOBALS['BE_USER']->uc = ['use_siteimprove' => 1];
        $GLOBALS['BE_USER']->method('getTSConfigVal')->willReturn(1);
        $GLOBALS['BE_USER']->method('getTSConfig')->willReturn(
            ['options.' => ['siteImprove.' => ['disable' => 1]]]
        );

        $pageRenderer = $this->createCompatibleMock(\TYPO3\CMS\Core\Page\PageRenderer::class);

        $this->subject->addResources(
            [],
            $pageRenderer
        );
    }
}
