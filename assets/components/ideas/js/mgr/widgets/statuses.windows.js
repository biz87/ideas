ideas.window.CreateStatus = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-status-window-create';
    }
    Ext.applyIf(config, {
        title: _('ideas_status_create'),
        width: 550,
        autoHeight: true,
        url: ideas.config.connector_url,
        action: 'mgr/status/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ideas.window.CreateStatus.superclass.constructor.call(this, config);
};
Ext.extend(ideas.window.CreateStatus, MODx.Window, {

    getFields: function (config) {
        return [ {
            xtype: 'textfield',
            fieldLabel: _('ideas_status_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ideas_status_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        },  {
            xtype: 'xcheckbox',
            boxLabel: _('ideas_status_active'),
            name: 'active',
            id: config.id + '-active',
            checked:true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ideas-status-window-create', ideas.window.CreateStatus);


ideas.window.UpdateStatus = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-status-window-update';
    }
    Ext.applyIf(config, {
        title: _('ideas_status_update'),
        width: 550,
        autoHeight: true,
        url: ideas.config.connector_url,
        action: 'mgr/status/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ideas.window.UpdateStatus.superclass.constructor.call(this, config);
};
Ext.extend(ideas.window.UpdateStatus, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('ideas_status_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ideas_status_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('ideas_status_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ideas-status-window-update', ideas.window.UpdateStatus);