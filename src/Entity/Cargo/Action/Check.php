<?php

namespace App\Entity\Cargo\Action;

use ApiPlatform\Metadata\ApiResource;
use App\Attribute\Version;
use App\Entity\Cargo\Abstract\LogisticsAction;
use App\Entity\Cargo\Abstract\LogisticsObject;
use App\Entity\Cargo\Agent\Actor;
use App\Entity\Cargo\Common\CheckTemplate;
use App\Entity\Cargo\Common\CheckTotalResult;
use Doctrine\ORM\Mapping as ORM;

/**
 * Action to describe a check
 *
 * @link https://onerecord.iata.org/ns/cargo#Check Ontology
 */
#[ORM\Entity]
#[ApiResource]
#[ORM\Table(name: 'check_action')]
#[Version('3.1 RC1')]
class Check extends LogisticsAction
{
    /**
     * Reference to the result of the Check
     *
     * @link https://onerecord.iata.org/ns/cargo#checkTotalResult Ontology
     */
    #[ORM\ManyToOne(targetEntity: CheckTotalResult::class)]
    protected ?CheckTotalResult $checkTotalResult = null;

    /**
     * Reference to the checked Object
     *
     * @link https://onerecord.iata.org/ns/cargo#checkedObject Ontology
     */
    #[ORM\ManyToOne(targetEntity: LogisticsObject::class)]
    protected ?LogisticsObject $checkedObject = null;

    /**
     * Reference to the Actor performing the Check
     *
     * @link https://onerecord.iata.org/ns/cargo#checker Ontology
     */
    #[ORM\ManyToOne(targetEntity: Actor::class)]
    protected ?Actor $checker = null;

    /**
     * Reference to the Template used in the Check
     *
     * @link https://onerecord.iata.org/ns/cargo#usedTemplate Ontology
     */
    #[ORM\ManyToOne(targetEntity: CheckTemplate::class)]
    protected ?CheckTemplate $usedTemplate = null;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return CheckTotalResult|null
     */
    public function getCheckTotalResult(): ?CheckTotalResult
    {
        return $this->checkTotalResult;
    }


    /**
     * @param CheckTotalResult|null $checkTotalResult
     * @return static
     */
    public function setCheckTotalResult(?CheckTotalResult $checkTotalResult): static
    {
        $this->checkTotalResult = $checkTotalResult;
        return $this;
    }


    /**
     * @return LogisticsObject|null
     */
    public function getCheckedObject(): ?LogisticsObject
    {
        return $this->checkedObject;
    }


    /**
     * @param LogisticsObject|null $checkedObject
     * @return static
     */
    public function setCheckedObject(?LogisticsObject $checkedObject): static
    {
        $this->checkedObject = $checkedObject;
        return $this;
    }


    /**
     * @return Actor|null
     */
    public function getChecker(): ?Actor
    {
        return $this->checker;
    }


    /**
     * @param Actor|null $checker
     * @return static
     */
    public function setChecker(?Actor $checker): static
    {
        $this->checker = $checker;
        return $this;
    }


    /**
     * @return CheckTemplate|null
     */
    public function getUsedTemplate(): ?CheckTemplate
    {
        return $this->usedTemplate;
    }


    /**
     * @param CheckTemplate|null $usedTemplate
     * @return static
     */
    public function setUsedTemplate(?CheckTemplate $usedTemplate): static
    {
        $this->usedTemplate = $usedTemplate;
        return $this;
    }
}
