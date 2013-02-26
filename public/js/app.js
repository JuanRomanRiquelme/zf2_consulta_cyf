
//Ext.require('Ext.container.Viewport');
Ext.require('Ext.panel.Panel');

Ext.application({
    name: 'CP',

    appFolder: 'js/ccyf',
    
    controllers: [
        'Exped'
    ],

    launch: function() {
        
        /*new Ext.container.Viewport({
            layout: 'fit',
            items: {
                xtype: 'expedlist'
            }
        });*/
        
        new Ext.panel.Panel({
            renderTo: Ext.getBody(),
            width: '100%',
            height: '80%',
            title: 'Contenedor Principal',
            items: [
                {
                    xtype: 'expedgrid',
                    title: 'Subpanel',
                    height: '100%',
                    width: '100%'
                }
            ]
        });
    }
});