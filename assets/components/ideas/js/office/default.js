Ext.onReady(function () {
    ideas.config.connector_url = OfficeConfig.actionUrl;

    var grid = new ideas.panel.Home();
    grid.render('office-ideas-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});