ideas.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('ideas_item_create'),
        width: 550,
        autoHeight: true,
        url: ideas.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ideas.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(ideas.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('ideas_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ideas_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('ideas_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ideas-item-window-create', ideas.window.CreateItem);


ideas.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('ideas_item_update'),
        width: 550,
        autoHeight: true,
        url: ideas.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ideas.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(ideas.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('ideas_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ideas_item_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'textfield',
            fieldLabel: _('ideas_item_status'),
            name: 'status',
            id: config.id + '-status',
            anchor: '99%',
            allowBlank: false,
        },{
            xtype: 'ideas-combo-type',
            fieldLabel: _('ideas_item_type'),
            name: 'type',
            id: config.id + '-type',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'ideas-combo-user',
            fieldLabel: _('ideas_item_user_id'),
            name: 'user_id',
            id: config.id + '-user_id',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('ideas_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ideas-item-window-update', ideas.window.UpdateItem);