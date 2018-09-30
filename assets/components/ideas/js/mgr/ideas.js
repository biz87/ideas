var ideas = function (config) {
    config = config || {};
    ideas.superclass.constructor.call(this, config);
};
Ext.extend(ideas, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('ideas', ideas);

ideas = new ideas();