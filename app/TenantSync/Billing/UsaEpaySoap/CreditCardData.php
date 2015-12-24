<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CreditCardData
{

    /**
     * @var string $AvsStreet
     */
    protected $AvsStreet = null;

    /**
     * @var string $AvsZip
     */
    protected $AvsZip = null;

    /**
     * @var string $CardCode
     */
    protected $CardCode = null;

    /**
     * @var string $CardExpiration
     */
    protected $CardExpiration = null;

    /**
     * @var string $CardNumber
     */
    protected $CardNumber = null;

    /**
     * @var boolean $CardPresent
     */
    protected $CardPresent = null;

    /**
     * @var string $CardType
     */
    protected $CardType = null;

    /**
     * @var string $CAVV
     */
    protected $CAVV = null;

    /**
     * @var string $DUKPT
     */
    protected $DUKPT = null;

    /**
     * @var int $ECI
     */
    protected $ECI = null;

    /**
     * @var boolean $InternalCardAuth
     */
    protected $InternalCardAuth = null;

    /**
     * @var string $MagStripe
     */
    protected $MagStripe = null;

    /**
     * @var string $MagSupport
     */
    protected $MagSupport = null;

    /**
     * @var string $Pares
     */
    protected $Pares = null;

    /**
     * @var string $Signature
     */
    protected $Signature = null;

    /**
     * @var string $TermType
     */
    protected $TermType = null;

    /**
     * @var string $XID
     */
    protected $XID = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getAvsStreet()
    {
      return $this->AvsStreet;
    }

    /**
     * @param string $AvsStreet
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setAvsStreet($AvsStreet)
    {
      $this->AvsStreet = $AvsStreet;
      return $this;
    }

    /**
     * @return string
     */
    public function getAvsZip()
    {
      return $this->AvsZip;
    }

    /**
     * @param string $AvsZip
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setAvsZip($AvsZip)
    {
      $this->AvsZip = $AvsZip;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardCode()
    {
      return $this->CardCode;
    }

    /**
     * @param string $CardCode
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setCardCode($CardCode)
    {
      $this->CardCode = $CardCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiration()
    {
      return $this->CardExpiration;
    }

    /**
     * @param string $CardExpiration
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setCardExpiration($CardExpiration)
    {
      $this->CardExpiration = $CardExpiration;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
      return $this->CardNumber;
    }

    /**
     * @param string $CardNumber
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setCardNumber($CardNumber)
    {
      $this->CardNumber = $CardNumber;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getCardPresent()
    {
      return $this->CardPresent;
    }

    /**
     * @param boolean $CardPresent
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setCardPresent($CardPresent)
    {
      $this->CardPresent = $CardPresent;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
      return $this->CardType;
    }

    /**
     * @param string $CardType
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setCardType($CardType)
    {
      $this->CardType = $CardType;
      return $this;
    }

    /**
     * @return string
     */
    public function getCAVV()
    {
      return $this->CAVV;
    }

    /**
     * @param string $CAVV
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setCAVV($CAVV)
    {
      $this->CAVV = $CAVV;
      return $this;
    }

    /**
     * @return string
     */
    public function getDUKPT()
    {
      return $this->DUKPT;
    }

    /**
     * @param string $DUKPT
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setDUKPT($DUKPT)
    {
      $this->DUKPT = $DUKPT;
      return $this;
    }

    /**
     * @return int
     */
    public function getECI()
    {
      return $this->ECI;
    }

    /**
     * @param int $ECI
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setECI($ECI)
    {
      $this->ECI = $ECI;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getInternalCardAuth()
    {
      return $this->InternalCardAuth;
    }

    /**
     * @param boolean $InternalCardAuth
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setInternalCardAuth($InternalCardAuth)
    {
      $this->InternalCardAuth = $InternalCardAuth;
      return $this;
    }

    /**
     * @return string
     */
    public function getMagStripe()
    {
      return $this->MagStripe;
    }

    /**
     * @param string $MagStripe
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setMagStripe($MagStripe)
    {
      $this->MagStripe = $MagStripe;
      return $this;
    }

    /**
     * @return string
     */
    public function getMagSupport()
    {
      return $this->MagSupport;
    }

    /**
     * @param string $MagSupport
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setMagSupport($MagSupport)
    {
      $this->MagSupport = $MagSupport;
      return $this;
    }

    /**
     * @return string
     */
    public function getPares()
    {
      return $this->Pares;
    }

    /**
     * @param string $Pares
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setPares($Pares)
    {
      $this->Pares = $Pares;
      return $this;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
      return $this->Signature;
    }

    /**
     * @param string $Signature
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setSignature($Signature)
    {
      $this->Signature = $Signature;
      return $this;
    }

    /**
     * @return string
     */
    public function getTermType()
    {
      return $this->TermType;
    }

    /**
     * @param string $TermType
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setTermType($TermType)
    {
      $this->TermType = $TermType;
      return $this;
    }

    /**
     * @return string
     */
    public function getXID()
    {
      return $this->XID;
    }

    /**
     * @param string $XID
     * @return \TenantSync\Billing\UsaEpaySoap\CreditCardData
     */
    public function setXID($XID)
    {
      $this->XID = $XID;
      return $this;
    }

}
