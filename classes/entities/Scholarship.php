<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 3/24/2018
 * Time: 7:20 PM
 */

abstract class Scholarship extends DataBasedEntity
{

    /**
     * @var string
     */
    protected $description;
    /**
     * GPA needed to obtain the scholarship
     *
     * @var float|null
     */
    protected $gpa;
    /**
     * @var string
     */
    protected $name;
    /**
     * Requirements to obtain the scholarship
     *
     * @var string
     */
    protected $requirements;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var int
     */
    protected $value;

    /**
     * @param int $pkID
     */
    public abstract function __construct1(int $pkID);

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float|null
     */
    public function getGpa(): ?float
    {
        return $this->gpa;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param Student $student
     * @return bool
     */
    public abstract function isStudentEligible(Student $student): bool;

    /**
     * @param string $description
     * @return bool
     */
    public function setDescription(string $description): bool
    {
        $this->syncHandler($this->description, $this->getDescription(), $description);
        return true;
    }

    /**
     * @param float|null $gpa
     * @return bool
     */
    public function setGpa(?float $gpa): bool
    {
        if (is_null($gpa) or ($gpa >= 0.0 and $gpa <= 4.0)) {
            $this->syncHandler($this->gpa, $this->getGpa(), $gpa);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setName(string $name): bool
    {
        $this->syncHandler($this->name, $this->getName(), $name);
        return true;
    }

    /**
     * @param string $requirements
     * @return bool
     */
    public function setRequirements(string $requirements): bool
    {
        $this->syncHandler($this->requirements, $this->getRequirements(), $requirements);
        return true;
    }

    /**
     * @param string $type
     * @return bool
     */
    public abstract function setType(string $type): bool;

    /**
     * @param int $value
     * @return bool
     */
    public function setValue(int $value): bool
    {
        if ($value >= 0) {
            $this->syncHandler($this->value, $this->getValue(), $value);
            return true;
        }
    }
}