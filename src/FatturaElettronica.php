<?php

/**
 * Copyright (C) 2018-2021 Taocomp s.r.l.s. <https://taocomp.com>
 *
 * This file is part of php-e-invoice-it.
 *
 * php-e-invoice-it is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-e-invoice-it is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-e-invoice-it.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Taocomp\Einvoicing;

class FatturaElettronica extends AbstractDocument
{
    /**
     * Constants for root element ("FatturaElettronica")
     */
    const ROOT_TAG_PREFIX = 'p';
    const ROOT_TAG_NAME   = 'FatturaElettronica';
    const ROOT_NAMESPACE  = 'http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2';
    const SCHEMA_LOCATION = 'http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 '
                          . 'http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa'
                          . '/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd';

    /**
     * Invoice formats
     */
    protected static $allowedFormats = array('FPA12', 'FPR12');

    /**
     * Default destination dir where to save documents
     */
    protected static $defaultPrefixPath = null;

    /**
     * Invoice elements
     */
    public static $templateArray = array(
        'FatturaElettronicaHeader' => [
            'DatiTrasmissione' => [
                'IdTrasmittente'       => ['IdPaese' => '', 'IdCodice' => ''],
                'ProgressivoInvio'     => '',
                'FormatoTrasmissione'  => '',
                'CodiceDestinatario'   => '',
                'ContattiTrasmittente' => ['Telefono' => '', 'Email' => ''],
                'PECDestinatario'      => '',
            ],
            'CedentePrestatore' => [
                'DatiAnagrafici' => [
                    'IdFiscaleIVA'         => [
                        'IdPaese'  => '',
                        'IdCodice' => '',
                    ],
                    'CodiceFiscale'        => '',
                    'Anagrafica'           => [
                        'Denominazione' => '',
                        'Nome'          => '',
                        'Cognome'       => '',
                        'Titolo'        => '',
                        'CodEORI'       => '',
                    ],
                    'AlboProfessionale'    => '',
                    'ProvinciaAlbo'        => '',
                    'NumeroIscrizioneAlbo' => '',
                    'DataIscrizioneAlbo'   => '',
                    'RegimeFiscale'        => '',
                ],
                'Sede' => [
                    'Indirizzo'    => '',
                    'NumeroCivico' => '',
                    'CAP'          => '',
                    'Comune'       => '',
                    'Provincia'    => '',
                    'Nazione'      => '',
                ],
                'StabileOrganizzazione' => [
                    'Indirizzo'    => '',
                    'NumeroCivico' => '',
                    'CAP'          => '',
                    'Comune'       => '',
                    'Provincia'    => '',
                    'Nazione'      => '',
                ],
                'IscrizioneREA' => [
                    'Ufficio'           => '',
                    'NumeroREA'         => '',
                    'CapitaleSociale'   => '',
                    'SocioUnico'        => '',
                    'StatoLiquidazione' => ''
                ],
                'Contatti' => [
                    'Telefono' => '',
                    'Fax'      => '',
                    'Email'    => '',
                ],
                'RiferimentoAmministrazione' => '',
            ],
            // Da valorizzare qualora il cedente/prestatore si avvalga di un
            // rappresentante fiscale in Italia, ai sensi del DPR 633 del 1972
            // e successive modifiche ed integrazioni.
            'RappresentanteFiscale' => [
                'DatiAnagrafici' => [
                    'IdFiscaleIVA'  => ['IdPaese' => '', 'IdCodice' => ''],
                    'CodiceFiscale' => '',
                    'Anagrafica'    => [
                        'Denominazione' => '',
                        'Nome'          => '',
                        'Cognome'       => '',
                        'Titolo'        => '',
                        'CodEORI'       => '',
                    ],
                ],
            ],
            'CessionarioCommittente' => [
                 'DatiAnagrafici' => [
                    'IdFiscaleIVA' => [
                        'IdPaese' => '',
                        'IdCodice' => ''
                    ],
                    'CodiceFiscale' => '',
                    'Anagrafica' => [
                        'Denominazione' => '',
                        'Nome' => '',
                        'Cognome' => '',
                        'Titolo' => '',
                        'CodEORI' => ''
                    ],
                ],
                 'Sede' => [
                     'Indirizzo'    => '',
                     'NumeroCivico' => '',
                     'CAP'          => '',
                     'Comune'       => '',
                     'Provincia'    => '',
                     'Nazione'      => '',
                 ],
                 'StabileOrganizzazione' => [
                     'Indirizzo'    => '',
                     'NumeroCivico' => '',
                     'CAP'          => '',
                     'Comune'       => '',
                     'Provincia'    => '',
                     'Nazione'      => '',
                 ],
                 'RappresentanteFiscale' => [
                     'IdFiscaleIVA'  => ['IdPaese' => '', 'IdCodice' => ''],
                     'Denominazione' => '',
                     'Nome'          => '',
                     'Cognome'       => '',
                 ],
            ],
            'TerzoIntermediarioOSoggettoEmittente' => [
                'DatiAnagrafici' => [
                    'IdFiscaleIVA' => ['IdPaese' => '', 'IdCodice' => ''],
                    'CodiceFiscale' => '',
                    'Anagrafica' => [
                        'Denominazione' => '',
                        'Nome'          => '',
                        'Cognome'       => '',
                        'Titolo'        => '',
                        'CodEORI'       => '',
                    ]
                ],
            ],
            // Nei casi di documenti emessi da un soggetto diverso dal
            // cedente/prestatore va valorizzato l’elemento seguente.
            'SoggettoEmittente' => ''
        ],
        'FatturaElettronicaBody' => array(
            'DatiGenerali' => [
                'DatiGeneraliDocumento' => [
                    // Tipologia del documento oggetto della trasmissione
                    // (fattura, acconto/anticipo su fattura, acconto/anticipo
                    // su parcella , nota di credito, nota di debito, parcella).
                    // TD01 Fattura
                    // TD02 Acconto/Anticipo su fattura
                    // TD03 Acconto/Anticipo su parcella
                    // TD04 Nota di Credito
                    // TD05 Nota di Debito
                    // TD06 Parcella
                    'TipoDocumento' => '',
                    'Divisa' => '',
                    'Data' => '',
                    'Numero' => '',
                    'DatiRitenuta' => [
                        'TipoRitenuta' => '',
                        'ImportoRitenuta' => '',
                        'AliquotaRitenuta' => '',
                        'CausalePagamento' => '',
                    ],
                    'DatiBollo' => [
                        'BolloVirtuale' => '',
                        'ImportoBollo' => '',
                    ],
                    'DatiCassaPrevidenziale' => [
                        'TipoCassa' => '',
                        'AlCassa' => '',
                        'ImportoContributoCassa' => '',
                        'ImponibileCassa' => '',
                        'AliquotaIVA' => '',
                        'Ritenuta' => '',
                        'Natura' => '',
                        'RiferimentoAmministrazione' => '',
                    ],
                    'ScontoMaggiorazione' => [
                        'Tipo' => '',
                        'Percentuale' => '',
                        'Importo' => ''
                    ],
                    'ImportoTotaleDocumento' => '',
                    'Arrotondamento' => '',
                    'Causale' => '',
                    'Art73' => '',
                ],
                'DatiOrdineAcquisto' => [
                    'RiferimentoNumeroLinea'    => '',
                    'IdDocumento'               => '',
                    'Data'                      => '',
                    'NumItem'                   => '',
                    'CodiceCommessaConvenzione' => '',
                    'CodiceCUP'                 => '',
                    'CodiceCIG'                 => '',
                ],
                'DatiContratto' => [
                    'RiferimentoNumeroLinea' => '',
                    'IdDocumento' => '',
                    'Data' => '',
                    'NumItem' => '',
                    'CodiceCommessaConvenzione' => '',
                    'CodiceCUP' => '',
                    'CodiceCIG' => '',
                ],
                'DatiConvenzione' => [
                    'RiferimentoNumeroLinea' => '',
                    'IdDocumento' => '',
                    'Data' => '',
                    'NumItem' => '',
                    'CodiceCommessaConvenzione' => '',
                    'CodiceCUP' => '',
                    'CodiceCIG' => '',
                ],
                'DatiRicezione' => [
                    'RiferimentoNumeroLinea' => '',
                    'IdDocumento' => '',
                    'Data' => '',
                    'NumItem' => '',
                    'CodiceCommessaConvenzione' => '',
                    'CodiceCUP' => '',
                    'CodiceCIG' => '',
                ],
                'DatiFattureCollegate' => [
                    'RiferimentoNumeroLinea' => '',
                    'IdDocumento' => '',
                    'Data' => '',
                    'NumItem' => '',
                    'CodiceCommessaConvenzione' => '',
                    'CodiceCUP' => '',
                    'CodiceCIG' => '',
                ],
                'DatiSAL' => [
                    'RiferimentoFase' => '',
                ],
                'DatiDDT' => [
                    'NumeroDDT' => '',
                    'DataDDT' => '',
                    'RiferimentoNumeroLinea' => ''
                ],
                'DatiTrasporto' => [
                    'DatiAnagraficiVettore' => array(
                        'IdFiscaleIVA' => array(
                            'IdPaese' => '',
                            'IdCodice' => ''
                        ),
                        'CodiceFiscale' => '',
                        'Anagrafica' => array(
                            'Denominazione' => '',
                            'Nome' => '',
                            'Cognome' => '',
                            'Titolo' => '',
                            'CodEORI' => ''
                        ),
                        'NumeroLicenzaGuida' => ''
                    ),
                    'MezzoTrasporto' => '',
                    'CausaleTrasporto' => '',
                    'NumeroColli' => '',
                    'Descrizione' => '',
                    'UnitaMisuraPeso' => '',
                    'PesoLordo' => '',
                    'PesoNetto' => '',
                    'DataOraRitiro' => '',
                    'DataInizioTrasporto' => '',
                    'TipoResa' => '',
                    'IndirizzoResa' => array(
                        'Indirizzo' => '',
                        'NumeroCivico' => '',
                        'CAP' => '',
                        'Comune' => '',
                        'Provincia' => '',
                        'Nazione' => ''
                    ),
                    'DataOraConsegna' => '',
                ],
                'FatturaPrincipale' => [
                    'NumeroFatturaPrincipale' => '',
                    'DataFatturaPrincipale' => ''
                ],
            ],
            'DatiBeniServizi' => [
                'DettaglioLinee' => array(
                    'NumeroLinea' => '',
                    'TipoCessionePrestazione' => '',
                    'CodiceArticolo' => array(
                        'CodiceTipo' => '',
                        'CodiceValore' => ''
                    ),
                    'Descrizione' => '',
                    'Quantita' => '',
                    'UnitaMisura' => '',
                    'DataInizioPeriodo' => '',
                    'DataFinePeriodo' => '',
                    'PrezzoUnitario' => '',
                    'ScontoMaggiorazione' => array(
                        'Tipo' => '',
                        'Percentuale' => '',
                        'Importo' => ''
                    ),
                    'PrezzoTotale' => '',
                    'AliquotaIVA' => '',
                    'Ritenuta' => '',
                    'Natura' => '',
                    'RiferimentoAmministrazione' => '',
                    'AltriDatiGestionali' => array(
                        'TipoDato' => '',
                        'RiferimentoTesto' => '',
                        'RiferimentoNumero' => '',
                        'RiferimentoData' => ''
                    )
                ),
                'DatiRiepilogo' => array(
                    'AliquotaIVA' => '',
                    'Natura' => '',
                    'SpeseAccessorie' => '',
                    'Arrotondamento' => '',
                    'ImponibileImporto' => '',
                    'Imposta' => '',
                    // I IVA ad esigibilità immediata
                    // D IVA ad esigibilità differita
                    // S scissione dei pagamenti
                    'EsigibilitaIVA' => '',
                    'RiferimentoNormativo' => ''
                )
            ],
            // Presenti nei casi di cessioni tra paesi membri di mezzi di
            // trasporto nuovi. Dati relativi ai veicoli di cui
            // all’art. 38, comma 4 del DL 331 del 1993.
            'DatiVeicoli' => [
                'Data' => '',
                'TotalePercorso' => ''
            ],
            'DatiPagamento' => [
                'CondizioniPagamento' => '',
                'DettaglioPagamento' => array(
                    'Beneficiario' => '',
                    'ModalitaPagamento' => '',
                    'DataRiferimentoTerminiPagamento' => '',
                    'GiorniTerminiPagamento' => '',
                    'DataScadenzaPagamento' => '',
                    'ImportoPagamento' => '',
                    'CodUfficioPostale' => '',
                    'CognomeQuietanzante' => '',
                    'NomeQuietanzante' => '',
                    'CFQuietanzante' => '',
                    'TitoloQuietanzante' => '',
                    'IstitutoFinanziario' => '',
                    'IBAN' => '',
                    'ABI' => '',
                    'CAB' => '',
                    'BIC' => '',
                    'ScontoPagamentoAnticipato' => '',
                    'DataLimitePagamentoAnticipato' => '',
                    'PenalitaPagamentiRitardati' => '',
                    'DataDecorrenzaPenale' => '',
                    'CodicePagamento' => ''
                )
            ],
            'Allegati' => [
                'NomeAttachment' => '',
                'AlgoritmoCompressione' => '',
                'FormatoAttachment' => '',
                'DescrizioneAttachment' => '',
                'Attachment' => ''
            ]
        )
    );

    protected $validator = null;

    /**
     * Constructor
     */
    public function __construct( string $arg )
    {
        $format = strtoupper($arg);

        if (true === in_array($format, self::$allowedFormats)) {
            // New invoice
            parent::__construct();
            $this->dom->documentElement->setAttribute('versione', $format);
            $this->setValue('FormatoTrasmissione', $format);
        } else {
            // Load invoice from file
            parent::__construct($arg);
        }
    }

    /**
     * Retrieve invoice filename from current element values
     * if $this->filename is not set
     */
    public function getFilename()
    {
        if (null !== $this->filename) {
            return $this->filename;
        }

        $progressivoInvio = $this->getValue('ProgressivoInvio');
        $codice = $this->getValue('IdCodice', 'CedentePrestatore');
        $paese = $this->getValue('IdPaese', 'CedentePrestatore');

        if (empty($progressivoInvio)) {
            throw new \Exception(__FUNCTION__ . ': ProgressivoInvio is empty');
        }
        if (empty($paese)) {
            throw new \Exception(__FUNCTION__ . ': IdPaese is empty');
        }
        if (empty($codice)) {
            throw new \Exception(__FUNCTION__ . ': IdCodice is empty');
        }

        return "{$paese}{$codice}_$progressivoInvio.xml";
    }

    /**
     * Override normalize to check for "Causale" length
     */
    public function normalize()
    {
        $bodies = $this->getBodies();
        foreach ($bodies as $body) {
            // Split "Causale" if needed
            $causaleCount = $this->query('DatiGeneraliDocumento/Causale', $body)->length;
            if ($causaleCount === 1) {
                $this->splitElement('DatiGeneraliDocumento/Causale', 200, $body);
            }
        }

        return parent::normalize();
    }

    public function validate()
    {
        if (null === $this->validator) {
            $this->validator = new \SlamFatturaElettronica\Validator();
        }

        $this->validator->assertValidXml($this->asXML());

        return $this;
    }

    /**
     * BODY
     ***************************************************************************
     */

    /**
     * Add body (invoice lot)
     */
    public function addBody( int $n = 1 )
    {
        if ($n < 1) {
            return $this;
        }

        $body = $this->getBody();

        for ($i = 0; $i < $n; $i++) {
            $this->addElement($body->cloneNode(true), '/');
        }

        return $this;
    }

    /**
     * Retrieve all bodies as \DOMNodeList
     */
    public function getBodies()
    {
        return $this->query('FatturaElettronicaBody');
    }

    /**
     * Get body
     */
    public function getBody( int $bodyIndex = 1 )
    {
        return $this->getElement("FatturaElettronicaBody[$bodyIndex]");
    }

    /**
     * Set number of bodies (invoice lot)
     */
    public function setBodyCount( int $n )
    {
        return $this->addBody($n - 1);
    }

    /**
     * LINE ITEMS
     ***************************************************************************
     */

    /**
     * Add line item
     */
    public function addLineItem( int $n, int $bodyIndex = 1 )
    {
        if ($n < 1) {
            return $this;
        }

        if ($bodyIndex < 1) {
            throw new \Exception("Invalid body index '$bodyIndex'");
        }

        $body = $this->getBody($bodyIndex);
        $line = $this->getElement('DettaglioLinee', $body);
        $parent = $this->getElement('DatiBeniServizi', $body);
        $beforeRef = $this->getElement('DatiRiepilogo', $body);

        for ($i = 0; $i < $n; $i++) {
            $this->addElement($line->cloneNode(true), $parent, $beforeRef);
        }

        return $this;
    }

    /**
     * Get line item i
     */
    public function getLineItem( int $i, int $bodyIndex = 1 )
    {
        $body = $this->getBody($bodyIndex);
        return $this->getElement("DettaglioLinee[$i]", $body);
    }

    /**
     * Set number of line items
     */
    public function setLineItemCount( int $n, int $bodyIndex = 1 )
    {
        return $this->addLineItem($n - 1, $bodyIndex);
    }
}
