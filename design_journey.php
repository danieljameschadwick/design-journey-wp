<?php

namespace DesignJourney;

use Timber\Timber;

class DesignJourney {
    /**
     * DesignJourney constructor.
     */
    private function __construct()
    {
        $this->registerHooks();
    }

    /**
     * @return DesignJourney
     */
    public static function instance(): self
    {
        return new self();
    }

    /**
     * @return void
     */
    private function registerHooks(): void
    {
        add_action('designjourney_show', array($this, 'show'));
        add_action('designjourney_show_page', array($this, 'designPageShow'));
    }

    private function getDirectory()
    {
        return plugin_dir_url(__FILE__);
    }

    /**
     * @return void
     */
    public function show(): void
    {
        $this->showLinkBlock();
    }

    /**
     * @return void
     */
    public function designPageShow(): void
    {
        //check what to render.. what stage the order is at
        $this->landingPageAction();

    }

    private function landingPageAction() {
        wp_enqueue_style('designjourney_style', $this->getDirectory() . '/view/css/main.css');
        wp_enqueue_style('designjourney_design_details', $this->getDirectory() . '/view/css/design_details.css');
        wp_enqueue_script('designjourney_design_details', $this->getDirectory() . '/view/js/design_details.js');

        Timber::render('/view/templates/landing_page.html.twig');
    }

    /**
     * @return void
     */
    private function showInitialForm(): void
    {
        wp_enqueue_style('designjourney_style', $this->getDirectory() . '/view/css/main.css');
        wp_enqueue_style('imagepicker_style', $this->getDirectory() . '/view/css/image_picker.css');
        wp_enqueue_script('imagepicker_script', $this->getDirectory() . '/view/js/import/image_picker.js');
        wp_enqueue_script('designjourney_script', $this->getDirectory() . '/view/js/main.js');

        $content = [
            'message' => 'To ensure we get off on the right foot please fill out the design form below. We promise it\'ll only take a couple of minutes and will allow us to tailor design to your needs.',
            'businessSize' => [
                'label' => 'What size would you estimate your business? If you have no idea, select not sure.',
            ],
        ];

        Timber::render('/view/templates/show.html.twig', $content);
    }

    /**
     * @return void
     */
    private function showLinkBlock(): void
    {
        $content = [
            'link' => '/design-journey',
            'message' => 'Click here to start your Design Journey.',
        ];

        Timber::render('/view/templates/show_link_block.html.twig', $content);
    }
}
