Ext.onReady(function(){
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.ScriptTagProxy({
			url: 'http://linserver/mdb/corrsucata_json.php'
		}),
		
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'sucata_id'
		}, [
				//sucata_id sucata_op sucata_peso maq_nome sucata_tipo sucata_data sucata_resp
				{name: 'sucata_op', mapping: 'sucata_op'},
				{name: 'maq_nome', mapping: 'maq_nome'},
				{name: 'sucata_tipo', mapping: 'sucata_tipo'},
				{name: 'sucata_peso', mapping: 'sucata_peso'},
				{name: 'sucata_data', mapping: 'sucata_data'}
		])		
	});

	var cm = new Ext.grid.ColumnModel([
		{
			id: 'sucata_op',
			header: "OP",
			dataIndex: 'sucata_op',
			width: 50
		},
		{
			header: 'Máquina',
			dataIndex: 'maq_nome',
			width: 70
		},
		{
			header: 'Tipo',
			dataIndex: 'sucata_tipo',
			width: 70
		},
		{
			header: 'Peso',
			dataIndex: 'sucata_peso',
			width: 70
		},
		{
			header: 'Data',
			dataIndex: 'sucata_data',
			width: 50
		}	
	]);
	
	var grid = new Ext.grid.Grid('grid-paging', {
		ds: ds,
		cm: cm,
		trackMouseOver: true,
		loadMask: true,
		autoExpandColumn: 'sucata_op',
		}
	);	
	
	grid.render();
	
	var gridHeader = grid.getView().getHeaderPanel(true);
	
	var paging = new Ext.PagingToolbar(gridHeader,ds, {
		pageSize: 15,
		displayInfo: true,
		displayMsg: 'Mostrando resultados {0} - {1} de {2}',
		emptyMsg: "Nenhum resultado retornado"
		}
	);	
	
	var gridFooter = grid.getView().getFooterPanel(true);
	
	var paging = new Ext.PagingToolbar(gridFooter,ds, {
		pageSize: 15,
		displayInfo: true,
		displayMsg: 'Mostrando resultados {0} - {1} de {2}',
		emptyMsg: "Nenhum resultado retornado"
		}
	);	
	
	ds.load({params:{start:0, limit:15}});	
	
});
