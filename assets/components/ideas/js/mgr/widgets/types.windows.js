ideas.window.CreateType = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-type-window-create';
    }
    Ext.applyIf(config, {
        title: _('ideas_type_create'),
        width: 550,
        autoHeight: true,
        url: ideas.config.connector_url,
        action: 'mgr/type/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ideas.window.CreateType.superclass.constructor.call(this, config);
};
Ext.extend(ideas.window.CreateType, MODx.Window, {

    getFields: function (config) {
        return [ {
            xtype: 'textfield',
            fieldLabel: _('ideas_type_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ideas_type_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('ideas_type_active'),
            name: 'active',
            id: config.id + '-active',
            checked:true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ideas-type-window-create', ideas.window.CreateType);


ideas.window.UpdateType = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-type-window-update';
    }
    Ext.applyIf(config, {
        title: _('ideas_type_update'),
        width: 550,
        autoHeight: true,
        url: ideas.config.connector_url,
        action: 'mgr/type/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ideas.window.UpdateType.superclass.constructor.call(this, config);
};
Ext.extend(ideas.window.UpdateType, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('ideas_type_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ideas_type_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'numberfield',
            fieldLabel: _('ideas_type_rank'),
            name: 'rank',
            anchor: '99%',
            id: config.id + '-rank',
        },{
            xtype: 'xcheckbox',
            boxLabel: _('ideas_type_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ideas-type-window-update', ideas.window.UpdateType);