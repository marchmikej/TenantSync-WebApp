<?php

namespace TenantSync\Billing\UsaEpaySoap;

class Receipt
{

    /**
     * @var int $ReceiptRefNum
     */
    protected $ReceiptRefNum = null;

    /**
     * @var string $Name
     */
    protected $Name = null;

    /**
     * @var string $Subject
     */
    protected $Subject = null;

    /**
     * @var string $FromEmail
     */
    protected $FromEmail = null;

    /**
     * @var string $Target
     */
    protected $Target = null;

    /**
     * @var string $ContentType
     */
    protected $ContentType = null;

    /**
     * @var string $TemplateHTML
     */
    protected $TemplateHTML = null;

    /**
     * @var string $TemplateText
     */
    protected $TemplateText = null;

    /**
     * @param string $Name
     * @param string $Target
     * @param string $ContentType
     */
    public function __construct($Name, $Target, $ContentType)
    {
      $this->Name = $Name;
      $this->Target = $Target;
      $this->ContentType = $ContentType;
    }

    /**
     * @return int
     */
    public function getReceiptRefNum()
    {
      return $this->ReceiptRefNum;
    }

    /**
     * @param int $ReceiptRefNum
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setReceiptRefNum($ReceiptRefNum)
    {
      $this->ReceiptRefNum = $ReceiptRefNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->Name;
    }

    /**
     * @param string $Name
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setName($Name)
    {
      $this->Name = $Name;
      return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
      return $this->Subject;
    }

    /**
     * @param string $Subject
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setSubject($Subject)
    {
      $this->Subject = $Subject;
      return $this;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
      return $this->FromEmail;
    }

    /**
     * @param string $FromEmail
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setFromEmail($FromEmail)
    {
      $this->FromEmail = $FromEmail;
      return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
      return $this->Target;
    }

    /**
     * @param string $Target
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setTarget($Target)
    {
      $this->Target = $Target;
      return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
      return $this->ContentType;
    }

    /**
     * @param string $ContentType
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setContentType($ContentType)
    {
      $this->ContentType = $ContentType;
      return $this;
    }

    /**
     * @return string
     */
    public function getTemplateHTML()
    {
      return $this->TemplateHTML;
    }

    /**
     * @param string $TemplateHTML
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setTemplateHTML($TemplateHTML)
    {
      $this->TemplateHTML = $TemplateHTML;
      return $this;
    }

    /**
     * @return string
     */
    public function getTemplateText()
    {
      return $this->TemplateText;
    }

    /**
     * @param string $TemplateText
     * @return \TenantSync\Billing\UsaEpaySoap\Receipt
     */
    public function setTemplateText($TemplateText)
    {
      $this->TemplateText = $TemplateText;
      return $this;
    }

}
