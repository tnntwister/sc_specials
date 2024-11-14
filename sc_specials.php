<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Sc_Specials extends Module
{
    public function __construct()
    {
        $this->name = 'sc_specials';
        $this->tab = 'pricing_promotion';
        $this->version = '1.0.0';
        $this->author = 'Your Name';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('SC Specials');
        $this->description = $this->l('Customize the promotions page by adding custom sorting logic.');
        $this->ps_versions_compliancy = ['min' => '1.7.6.0', 'max' => _PS_VERSION_];
    }

    public function install()
    {
        return parent::install() && $this->registerHook('actionDispatcher');
    }

    public function hookActionDispatcher($params)
    {
        if ($params['controller_class'] === 'PricesDropController') {
            $params['controller']->setProductSearchProvider(
                new \ScSpecials\Search\CustomPricesDropSearchProvider()
            );
        }

        if ($params['controller_class'] === 'PricesDropController') {
            require_once __DIR__ . '/src/Override/Controllers/Front/Listing/PricesDropController.php';
        }
    }
}
