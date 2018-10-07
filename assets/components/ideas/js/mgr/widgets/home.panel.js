ideas.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'ideas-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('ideas') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('ideas_items'),
                layout: 'anchor',
                items: [{
                    html: _('ideas_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'ideas-grid-items',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('ideas_statuses'),
                layout: 'anchor',
                items: [{
                    html: _('ideas_statuses_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'ideas-grid-statuses',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    ideas.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(ideas.panel.Home, MODx.Panel);
Ext.reg('ideas-panel-home', ideas.panel.Home);
