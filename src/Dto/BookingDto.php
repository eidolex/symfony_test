<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookingDto
{
    /**
     * @param array<int, mixed> $items
     */
    public function __construct(
        #[Assert\NotBlank] public string $name,
        #[Assert\NotBlank, Assert\Email] public string $email,
        #[Assert\NotBlank] public string $phone,
        #[
            Assert\Count(min: 1),
            Assert\All([
                new Assert\Collection(
                    [
                        "id" => new Assert\NotBlank(),
                    ],
                    allowExtraFields: true
                ),
            ])
        ]
        public array $items
    ) {
    }
}
