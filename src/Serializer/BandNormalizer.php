<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Band;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BandNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (Band::class !== $type) {
            return null;
        }
        $existingBand = $context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? null;

        if ($existingBand instanceof Band) {
            $band = $existingBand;
        } else {
            $band = new Band();
        }

        if (isset($data['name'])) {
            $band->setName($data['name']);
        }
        if (isset($data['origin'])) {
            $band->setOrigin($data['origin']);
        }
        if (isset($data['city'])) {
            $band->setCity($data['city']);
        }
        if (isset($data['startYear'])) {
            $band->setStartYear((int) $data['startYear']);
        }
        if (isset($data['separationYear'])) {
            $band->setSeparationYear((int) $data['separationYear']);
        }
        if (isset($data['founders'])) {
            $band->setFounders($data['founders']);
        }
        if (isset($data['members'])) {
            $band->setMembers((int) $data['members']);
        }
        if (isset($data['musicalCurrent'])) {
            $band->setMusicalCurrent($data['musicalCurrent']);
        }
        if (isset($data['presentation'])) {
            $band->setPresentation($data['presentation']);
        }

        return $band;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Band::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Band::class => true];
    }
}
