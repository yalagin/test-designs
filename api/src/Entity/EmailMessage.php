<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;


/**
 * An email message.
 *
 * @see http://schema.org/EmailMessage Documentation on Schema.org
 *
 * @author Maxim Yalagin <yalagin@gmail.com>
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/EmailMessage",attributes={"order"={"dateReceived": "desc"}})
 * @ApiFilter(DateFilter::class, properties={"dateReceived"})
 * @ApiFilter(OrderFilter::class, properties={"sender", "toRecipient","about","text","dateReceived"}, arguments={"orderParameterName"="order"})
 *
 */
#[ApiResource(
    collectionOperations: [
        "get",
        "post"
    ],
    itemOperations: [
        "get",
        "put",
        "patch",
        "delete"
    ],
    attributes: ["order"=>["dateReceived"=> "desc"]],
    denormalizationContext: ["groups" => ['subdesign','get']],
    elasticsearch: false, normalizationContext: ["groups" => ['subdesign']]
)]
class EmailMessage
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @Assert\Uuid
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     *  @Groups({"get"})
     */
    private $id;

    /**
     * @var string|null A sub property of participant. The participant who is at the sending end of the action.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/sender")
     * @Groups({"subdesign"})
     */
    private $sender;

    /**
     * @var string|null A sub property of recipient. The recipient who was directly sent the message.
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/toRecipient")
     *  @Groups({"subdesign"})
     */
    private $toRecipient;

    /**
     * @var string|null the subject matter of the content
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/about")
     *  @Groups({"subdesign"})
     */
    private $about;

    /**
     * @var string|null the textual content of this CreativeWork
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/text")
     *  @Groups({"subdesign"})
     */
    private $text;

    /**
     * @var DateTimeInterface|null the date/time the message was received if a single recipient exists
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @ApiProperty(iri="http://schema.org/dateReceived")
     * @Assert\Type("\DateTimeInterface")
     *  @Groups({"subdesign"})
     */
    private $dateReceived;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     *  @Groups({"subdesign"})
     */
    private $attachment = false;

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setSender(?string $sender): void
    {
        $this->sender = $sender;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setToRecipient(?string $toRecipient): void
    {
        $this->toRecipient = $toRecipient;
    }

    public function getToRecipient(): ?string
    {
        return $this->toRecipient;
    }

    public function setAbout(?string $about): void
    {
        $this->about = $about;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setDateReceived(?DateTimeInterface $dateReceived): void
    {
        $this->dateReceived = $dateReceived;
    }

    public function getDateReceived(): ?DateTimeInterface
    {
        return $this->dateReceived;
    }

    public function setAttachment(?bool $attachment): void
    {
        $this->attachment = $attachment;
    }

    public function getAttachment(): ?bool
    {
        return $this->attachment;
    }
}
