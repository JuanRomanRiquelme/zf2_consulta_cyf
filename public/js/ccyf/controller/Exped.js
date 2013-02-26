/*
 * Exped Controller
 */

Ext.define('CP.controller.Exped', {
    extend: 'Ext.app.Controller',
    models: 'Exped',
    
    views: [
        'exped.List',
        'exped.Grid'
    ],

    init: function() {
        //console.log('Initialized Exped! This happens before the Application launch function is called');
        this.control({
            'expedlist': {
                render: this.onPanelRendered
            },
            'expedgrid': {
                render: this.onPanelRendered
            }
        });
    },
    
    onPanelRendered: function() {
        console.log('The panel was rendered');
    }
    
});