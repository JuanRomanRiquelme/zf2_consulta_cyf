//Ext.create('Ext.grid.Panel', {
/*
 * Exped View - Grid
 */

Ext.define('CP.view.exped.Grid' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.expedgrid',
    renderTo: Ext.getBody(),
    store: Exped,
    width: 400,
    height: 200,
    title: 'Expedientes EXTJS',
    columns: [
        {
            text: 'ID',
            width: 100,
            sortable: false,
            hideable: false,
            dataIndex: 'id'
        },
        {
            text: 'Num',
            width: 150,
            dataIndex: 'num'
        },
        {
            text: 'Codigo',
            flex: 1,
            dataIndex: 'codigo'
        },
        {
            text: 'Exp Adm',
            flex: 1,
            dataIndex: 'num_exp_adm'
        }
    ]
});