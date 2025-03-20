<?php

namespace App\DTO;

class RateDTO
{
    public function __construct(
        public int $id,
        public string $courier_id,
        public string $user_id,
        public int $rate,
        public string $created_at,
        public string $updated_at
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            courier_id: $data['courier_id'],
            user_id: $data['user_id'],
            rate: $data['rate'],
            created_at: $data['created_at'],
            updated_at: $data['updated_at']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'courier_id' => $this->courier_id,
            'user_id' => $this->user_id,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
