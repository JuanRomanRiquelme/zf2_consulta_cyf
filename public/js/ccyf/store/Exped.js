/*
 * Exped Store
 */

Ext.define('CP.store.Exped', {
    extend: 'Ext.data.Store',
    model: 'Exped',
    data: [
        { id: '1', num: '12345', codigo: '555-111-1224', num_exp_adm: '12' },
        { id: '12', num: '123456', codigo: '555-111-1224', num_exp_adm: '12' },
        { id: '123', num: '1234567', codigo: '555-111-1224', num_exp_adm: '12' },
        { id: '1345', num: '12345678', codigo: '555-111-1224', num_exp_adm: '12' },
    ]
    /*proxy: {
        type: 'ajax',
        url : '/exped/search',
        reader: 'json'
    },
    autoLoad: true
    */
});