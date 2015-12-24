<?php

namespace TenantSync\Billing\UsaEpaySoap;

class SyncLog
{

    /**
     * @var int $SyncPosition
     */
    protected $SyncPosition = null;

    /**
     * @var string $ObjectName
     */
    protected $ObjectName = null;

    /**
     * @var string $RefNum
     */
    protected $RefNum = null;

    /**
     * @var \DateTime $ChangeDate
     */
    protected $ChangeDate = null;

    /**
     * @var string $Action
     */
    protected $Action = null;

    /**
     * @param int $SyncPosition
     * @param string $ObjectName
     * @param string $RefNum
     * @param \DateTime $ChangeDate
     * @param string $Action
     */
    public function __construct($SyncPosition, $ObjectName, $RefNum, \DateTime $ChangeDate, $Action)
    {
      $this->SyncPosition = $SyncPosition;
      $this->ObjectName = $ObjectName;
      $this->RefNum = $RefNum;
      $this->ChangeDate = $ChangeDate->format(\DateTime::ATOM);
      $this->Action = $Action;
    }

    /**
     * @return int
     */
    public function getSyncPosition()
    {
      return $this->SyncPosition;
    }

    /**
     * @param int $SyncPosition
     * @return \TenantSync\Billing\UsaEpaySoap\SyncLog
     */
    public function setSyncPosition($SyncPosition)
    {
      $this->SyncPosition = $SyncPosition;
      return $this;
    }

    /**
     * @return string
     */
    public function getObjectName()
    {
      return $this->ObjectName;
    }

    /**
     * @param string $ObjectName
     * @return \TenantSync\Billing\UsaEpaySoap\SyncLog
     */
    public function setObjectName($ObjectName)
    {
      $this->ObjectName = $ObjectName;
      return $this;
    }

    /**
     * @return string
     */
    public function getRefNum()
    {
      return $this->RefNum;
    }

    /**
     * @param string $RefNum
     * @return \TenantSync\Billing\UsaEpaySoap\SyncLog
     */
    public function setRefNum($RefNum)
    {
      $this->RefNum = $RefNum;
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getChangeDate()
    {
      if ($this->ChangeDate == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->ChangeDate);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $ChangeDate
     * @return \TenantSync\Billing\UsaEpaySoap\SyncLog
     */
    public function setChangeDate(\DateTime $ChangeDate)
    {
      $this->ChangeDate = $ChangeDate->format(\DateTime::ATOM);
      return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
      return $this->Action;
    }

    /**
     * @param string $Action
     * @return \TenantSync\Billing\UsaEpaySoap\SyncLog
     */
    public function setAction($Action)
    {
      $this->Action = $Action;
      return $this;
    }

}
