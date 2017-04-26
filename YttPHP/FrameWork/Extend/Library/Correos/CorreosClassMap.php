<?php
/**
 * File for the class which returns the class map definition
 * @package Correos
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
/**
 * Class which returns the class map definition by the static method CorreosClassMap::classMap()
 * @package Correos
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2016-10-17
 */
class CorreosClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
        return array (
  'ADUANATYPE' => 'CorreosStructADUANATYPE',
  'AdmisionHomepaq' => 'CorreosEnumAdmisionHomepaq',
  'DATOSADUANATYPE' => 'CorreosStructDATOSADUANATYPE',
  'DATOSBULTOERRORTYPE' => 'CorreosStructDATOSBULTOERRORTYPE',
  'DATOSBULTOTYPE' => 'CorreosStructDATOSBULTOTYPE',
  'DATOSDESTINATARIOETIQUETATYPE' => 'CorreosStructDATOSDESTINATARIOETIQUETATYPE',
  'DATOSDESTINATARIOMODIFTYPE' => 'CorreosStructDATOSDESTINATARIOMODIFTYPE',
  'DATOSDESTINATARIOREEXPTYPE' => 'CorreosStructDATOSDESTINATARIOREEXPTYPE',
  'DATOSDESTINATARIOTYPE' => 'CorreosStructDATOSDESTINATARIOTYPE',
  'DATOSENVIOMODIFTYPE' => 'CorreosStructDATOSENVIOMODIFTYPE',
  'DATOSENVIOTYPE' => 'CorreosStructDATOSENVIOTYPE',
  'DATOSETIQUETAXMLTYPE' => 'CorreosStructDATOSETIQUETAXMLTYPE',
  'DATOSREMITENTEETIQUETATYPE' => 'CorreosStructDATOSREMITENTEETIQUETATYPE',
  'DATOSREMITENTEMODIFTYPE' => 'CorreosStructDATOSREMITENTEMODIFTYPE',
  'DATOSREMITENTETYPE' => 'CorreosStructDATOSREMITENTETYPE',
  'DIRECCIONTYPE' => 'CorreosStructDIRECCIONTYPE',
  'DUA' => 'CorreosEnumDUA',
  'DescAduanera' => 'CorreosStructDescAduanera',
  'ERRORVALTYPE' => 'CorreosStructERRORVALTYPE',
  'ETIQUETATYPE' => 'CorreosStructETIQUETATYPE',
  'EntregaExclusiva' => 'CorreosEnumEntregaExclusiva',
  'FICHEROADJUNTOTYPE' => 'CorreosStructFICHEROADJUNTOTYPE',
  'Formato' => 'CorreosEnumFormato',
  'IDENTIFICACIONTYPE' => 'CorreosStructIDENTIFICACIONTYPE',
  'Idioma' => 'CorreosEnumIdioma',
  'InstruccionesDevolucion' => 'CorreosEnumInstruccionesDevolucion',
  'LISTAERRORESVALIDACIONTYPE' => 'CorreosStructLISTAERRORESVALIDACIONTYPE',
  'ModDevEtiqueta' => 'CorreosEnumModDevEtiqueta',
  'ModalidadEntrega' => 'CorreosEnumModalidadEntrega',
  'Modo' => 'CorreosEnumModo',
  'PESOTYPE' => 'CorreosStructPESOTYPE',
  'PRUEBAENTREGATYPE' => 'CorreosStructPRUEBAENTREGATYPE',
  'Pesos' => 'CorreosStructPesos',
  'PeticionAnular' => 'CorreosStructPeticionAnular',
  'PeticionBaja' => 'CorreosStructPeticionBaja',
  'PeticionGenerarCodigoExpedicion' => 'CorreosStructPeticionGenerarCodigoExpedicion',
  'PeticionModificar' => 'CorreosStructPeticionModificar',
  'PeticionPreRegistroIdaVta' => 'CorreosStructPeticionPreRegistroIdaVta',
  'PeticionReexpedicion' => 'CorreosStructPeticionReexpedicion',
  'PreregistroCodEnvio' => 'CorreosStructPreregistroCodEnvio',
  'PreregistroCodExpedicion' => 'CorreosStructPreregistroCodExpedicion',
  'PreregistroEnvio' => 'CorreosStructPreregistroEnvio',
  'REEMBOLSOTYPE' => 'CorreosStructREEMBOLSOTYPE',
  'RepartoSabado' => 'CorreosEnumRepartoSabado',
  'RespuestaAnular' => 'CorreosStructRespuestaAnular',
  'RespuestaBaja' => 'CorreosStructRespuestaBaja',
  'RespuestaGenerarCodigoExpedicion' => 'CorreosStructRespuestaGenerarCodigoExpedicion',
  'RespuestaModificar' => 'CorreosStructRespuestaModificar',
  'RespuestaPreRegistroIdaVta' => 'CorreosStructRespuestaPreRegistroIdaVta',
  'RespuestaPreregistroCodEnvio' => 'CorreosStructRespuestaPreregistroCodEnvio',
  'RespuestaPreregistroCodExpedicion' => 'CorreosStructRespuestaPreregistroCodExpedicion',
  'RespuestaPreregistroEnvio' => 'CorreosStructRespuestaPreregistroEnvio',
  'RespuestaReexpedicion' => 'CorreosStructRespuestaReexpedicion',
  'RespuestaSolicitudDocumentacionAduanera' => 'CorreosStructRespuestaSolicitudDocumentacionAduanera',
  'RespuestaSolicitudDocumentacionAduaneraCN23CP71' => 'CorreosStructRespuestaSolicitudDocumentacionAduaneraCN23CP71',
  'RespuestaSolicitudEtiqueta' => 'CorreosStructRespuestaSolicitudEtiqueta',
  'RespuestaSolicitudEtiquetaExp' => 'CorreosStructRespuestaSolicitudEtiquetaExp',
  'RespuestaSolicitudEtiquetaRefCli' => 'CorreosStructRespuestaSolicitudEtiquetaRefCli',
  'RespuestaValidarDatos' => 'CorreosStructRespuestaValidarDatos',
  'Resultado' => 'CorreosEnumResultado',
  'SMSTYPE' => 'CorreosStructSMSTYPE',
  'SolicitudDocumentacionAduanera' => 'CorreosStructSolicitudDocumentacionAduanera',
  'SolicitudDocumentacionAduaneraCN23CP71' => 'CorreosStructSolicitudDocumentacionAduaneraCN23CP71',
  'SolicitudEtiqueta' => 'CorreosStructSolicitudEtiqueta',
  'SolicitudEtiquetaExp' => 'CorreosStructSolicitudEtiquetaExp',
  'SolicitudEtiquetaRefCli' => 'CorreosStructSolicitudEtiquetaRefCli',
  'TipoEnvio' => 'CorreosEnumTipoEnvio',
  'TipoFranqueo' => 'CorreosEnumTipoFranqueo',
  'TipoPeso' => 'CorreosEnumTipoPeso',
  'Tipo_Doc' => 'CorreosEnumTipo_Doc',
  'VAETIQUETATYPE' => 'CorreosStructVAETIQUETATYPE',
  'VATYPE' => 'CorreosStructVATYPE',
  'ValidarDatos' => 'CorreosStructValidarDatos',
  'eAR' => 'CorreosEnumEAR',
);
    }
}
