ideas.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'ideas-panel-home',
            renderTo: 'ideas-panel-home-div'
        }]
    });
    ideas.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(ideas.page.Home, MODx.Component);
Ext.reg('ideas-page-home', ideas.page.Home);