<?php
return array(
	'FechaOperacion'	=> @date('d-m-Y H:i:s'),
	'CodEtiquetador'	=> '',
	'NumContrato'		=> NULL,
	'NumCliente'		=> NULL,
	'Care'				=> '000000',//6	String	Aggregation code of shipment list. By default  000000
	'TotalBultos'		=> 1,//Integer	Always to 1.
	'ModDevEtiqueta'	=> 2,//1	String	Way in which the request is made for the label in the request answer:1.	XML. 2.	PDF
							//标签返回方式 1:xml 2:pdf
	'Remitente'			=> array(
		'Identificacion'	=> array(
			'Nombre'	=> 'EDA WAREHOUSING034， S.L',
		),
		'DatosDireccion'	=> array(
			'Direccion'	=> 'C/Nogal,4-poI,Ind.Los Huertecillo',
			'Localidad'	=> 'Ciempozuelos',
			'Provincia'	=> 'Madrid',
		),
		'DatosDireccion2'	=> NULL,
		'CP'				=> '28350',
	),
	'Destinatario'		=> array(
		'Identificacion'	=> array(
			'Nombre'	=> 'Francisco Miranda Lasheras',
		),
		'DatosDireccion'	=> array(
			'Direccion'	=> '~~~Via Dublin 7 Piso 6',
			'Localidad'	=> 'Madrid',
			'Provincia'	=> 'Madrid',
		),
		'DatosDireccion2'	=> NULL,
		'CP'				=> '28042',
		'Pais'				=> 'ES',
		'Telefonocontacto'	=> '915963474,5963474',
		'Email'				=> '',
	),
	'Envio'				=> array(
		'NumBulto'				=> '01',
		'CodProducto'			=> 'S0132',
		'ReferenciaCliente'		=> 'PA00001',
		'ReferenciaCliente2'	=> 'REFERENCIA002',
		'TipoFranqueo'			=> 'FP',
		'ModalidadEntrega'		=> 'ST',
		'Pesos'	=> array(
			'Peso'	=> array(
				'TipoPeso'	=> 'R',
				'Valor'		=> 3,
			),
		),
		'Largo'			=> 12,
		'Alto'			=> 10,
		'Ancho'			=> 15,
	),
	'EntregaParcial'	=> NULL,
	'CodExpedicion'		=> NULL,
);