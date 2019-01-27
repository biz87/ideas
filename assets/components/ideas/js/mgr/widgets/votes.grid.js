ideas.grid.Votes = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ideas-grid-votes';
    }
    Ext.applyIf(config, {
        url: ideas.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/vote/getlist'
        },
        listeners: {
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'ideas-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    ideas.grid.Votes.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(ideas.grid.Votes, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = ideas.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    removeVote: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('ideas_votes_remove')
                : _('ideas_vote_remove'),
            text: ids.length > 1
                ? _('ideas_votes_remove_confirm')
                : _('ideas_vote_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/vote/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    getFields: function () {
        return ['id', 'post_id', 'post',  'user', 'vote', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('ideas_vote_post'),
            dataIndex: 'post',
            sortable: true,
            width: 200,
        },{
            header: _('ideas_vote_user'),
            dataIndex: 'user',
            sortable: true,
            width: 200,
        },{
            header: _('ideas_vote_votetype'),
            dataIndex: 'vote',
            sortable: true,
            width: 200,
        },{
            header: _('ideas_grid_actions'),
            dataIndex: 'actions',
            renderer: ideas.utils.renderActions,
            sortable: false,
            width: 50,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            xtype: 'ideas-combo-posts'
            ,id: 'tbar-ideas-combo-posts'
            ,width: 200
            ,addall: true
            ,emptyText: _('ideas_filter_posts')
            ,listeners: {
                select: {fn: this.filterByPost, scope:this}
            }
            ,baseParams: {
                action: 'mgr/item/getlist',
                combo: true,
                rules: true
            }
        },{
            xtype: 'ideas-combo-user'
            ,id: 'tbar-ideas-combo-users'
            ,width: 200
            ,addall: true
            ,emptyText: _('ideas_filter_user')
            ,listeners: {
                select: {fn: this.filterByPost, scope:this}
            }
            ,url: ideas.config.connector_url
            ,baseParams: {
                action: 'mgr/item/getlist',
                combo: true,
                rules: true
            }
        },{
            xtype: 'button'
            ,id: 'ideas-filters-clearres'
            ,text: '<i class="icon icon-times"></i>'
            ,listeners: {
                click: {fn: this.clearFilter, scope: this}
            }
        }, '->', {
            xtype: 'ideas-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },

    filterByPost: function(cb) {
        this.getStore().baseParams['page'] = cb.value;
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },

    clearFilter: function(btn,e) {
        var s = this.getStore();
        s.baseParams['page'] = '';
        Ext.getCmp('tbar-ideas-combo-posts').setValue('');
        Ext.getCmp('tbar-ideas-combo-users').setValue('');
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },


    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },


});
Ext.reg('ideas-grid-votes', ideas.grid.Votes);
