<?php
return array(
	'FechaOperacion'	=> @date('d-m-Y H:i:s'),//*
	'codCertificado'	=> 'PQXXX10700043420128042Z',//*
	'CodEtiquetador'	=> '',//*
	'Care'				=> '000000',//*
	'TotalBultos'		=> 1,//*
	'ModDevEtiqueta'	=> 2,//*标签返回方式 1:xml 2:pdf
	'RemitenteModif'	=> array(//*
		'Identificacion'	=> array(//*
			'Nombre'			=> 'EDA WAREHOUSING034， S.L',//*
		),
		'DatosDireccion'	=> array(//*
			'Direccion'		=> 'C/Nogal,4-poI,Ind.Los Huertecillo',//*
			'Localidad'		=> 'Ciempozuelos',//*
			'Provincia'		=> 'Madrid',
		),
	),
	'DestinatarioModif'	=> array(//*
		'Identificacion'	=> array(//*
			'Nombre'	=> 'Francisco Miranda Lasheras',
		),
		'DatosDireccion'	=> array(//*
			'Direccion'		=> 'Via Dublin 7 Piso 6',//*
			'Localidad'		=> 'Madrid',//*
			'Provincia'		=> 'Madrid',
		),
		'Pais'				=> 'ES',
	),
	'EnvioModif'			=> array(//*
		'ReferenciaCliente'			=> 'PA00001',
		'ReferenciaCliente2'		=> 'REFERENCIA002',
		'TipoFranqueo'				=> 'FP',//*
		'Pesos'	=> array(//*
			'Peso'	=> array(//*
				'TipoPeso'	=> 'R',//*
				'Valor'		=> 3,//*
			),
		),
		'Largo'						=> 12,
		'Alto'						=> 10,
		'Ancho'						=> 15,
	),
);