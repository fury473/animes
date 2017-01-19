<?php

namespace Fury473\Bundle\AtarashiiBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class Account
 * @author Olivier Haag <olivierhaag92@gmail.com>
 */
class Account implements DenormalizableInterface, UserInterface
{

    /**
     * @var int
     */
    private $completed;
    /**
     * @var float
     */
    private $daysSpent;
    /**
     * @var int
     */
    private $dropped;
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $onHold;
    /**
     * @var int
     */
    private $ongoing;
    /**
     * @var int
     */
    private $planned;
    /**
     * @var string
     */
    private $username;

    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        $account = new static();
        $account->setId($data['user_id']);
        $account->setUsername($data['user_name']);
        $account->setOngoing(isset($data['user_watching']) ? $data['user_watching'] : $data['user_reading']);
        $account->setCompleted($data['user_completed']);
        $account->setOnHold($data['user_onhold']);
        $account->setDropped($data['user_dropped']);
        $account->setPlanned(isset($data['user_plantowatch']) ? $data['user_plantowatch'] : $data['user_plantoread']);
        $account->setDaysSpent($data['user_days_spent_watching']);
        return $account;
    }

    /**
     * @inheritdoc
     */
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * @return int
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @return float
     */
    public function getDaysSpent()
    {
        return $this->daysSpent;
    }

    /**
     * @return int
     */
    public function getDropped()
    {
        return $this->dropped;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOnHold()
    {
        return $this->onHold;
    }

    /**
     * @return int
     */
    public function getOngoing()
    {
        return $this->ongoing;
    }

    /**
     * @inheritdoc
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * @return int
     */
    public function getPlanned()
    {
        return $this->planned;
    }

    /**
     * @inheritdoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritdoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param int $completed
     * @return Account
     */
    public function setCompleted($completed)
    {
        $this->completed = (int)$completed;
        return $this;
    }

    /**
     * @param float $daysSpent
     * @return Account
     */
    public function setDaysSpent($daysSpent)
    {
        $this->daysSpent = (float)$daysSpent;
        return $this;
    }

    /**
     * @param int $dropped
     * @return Account
     */
    public function setDropped($dropped)
    {
        $this->dropped = (int)$dropped;
        return $this;
    }

    /**
     * @param int $id
     * @return Account
     */
    public function setId($id)
    {
        $this->id = (int)$id;
        return $this;
    }

    /**
     * @param int $onHold
     * @return Account
     */
    public function setOnHold($onHold)
    {
        $this->onHold = (int)$onHold;
        return $this;
    }

    /**
     * @param int $ongoing
     * @return Account
     */
    public function setOngoing($ongoing)
    {
        $this->ongoing = (int)$ongoing;
        return $this;
    }

    /**
     * @param int $planned
     * @return Account
     */
    public function setPlanned($planned)
    {
        $this->planned = (int)$planned;
        return $this;
    }

    /**
     * @param string $username
     * @return Account
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
}
