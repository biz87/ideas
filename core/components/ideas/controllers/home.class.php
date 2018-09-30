<?php

/**
 * The home manager controller for ideas.
 *
 */
class ideasHomeManagerController extends modExtraManagerController
{
    /** @var ideas $ideas */
    public $ideas;


    /**
     *
     */
    public function initialize()
    {
        $this->ideas = $this->modx->getService('ideas', 'ideas', MODX_CORE_PATH . 'components/ideas/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['ideas:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('ideas');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->ideas->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/ideas.js');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->ideas->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        ideas.config = ' . json_encode($this->ideas->config) . ';
        ideas.config.connector_url = "' . $this->ideas->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "ideas-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="ideas-panel-home-div"></div>';

        return '';
    }
}