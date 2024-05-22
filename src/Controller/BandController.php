<?php

namespace App\Controller;

use App\Entity\Band;
use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BandController extends AbstractController
{
    public function __construct(
        private readonly BandRepository $bandRepository
    ) {
    }

    #[Route('/band', name: 'app_band_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->bandRepository->findAll()
        );
    }

    #[Route('/band/{id}', name: 'app_band_show_one', methods: ['GET'])]
    public function show(Band $band): JsonResponse
    {
        return $this->json($band);
    }

    #[Route('/band', name: 'app_band_create', methods: ['POST'])]
    public function create(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $band = $serializer->deserialize(
            $request->getContent(),
            Band::class,
            'json'
        );

        $errors = $validator->validate($band);
        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $this->bandRepository->save($band);

        return $this->json($band, 201);
    }

    #[Route('/band/{id}', name: 'app_band_update', methods: ['PUT'])]
    public function update(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Band $band
    ): JsonResponse {
        $band = $serializer->deserialize(
            $request->getContent(),
            Band::class,

            'json',
            [
                AbstractNormalizer::OBJECT_TO_POPULATE => $band,
            ]
        );

        $errors = $validator->validate($band);
        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $this->bandRepository->save($band);
        return $this->json($band);
    }

    #[Route('/band/{id}', name: 'app_band_delete', methods: ['DELETE'])]
    public function delete(Band $band): JsonResponse
    {
        $this->bandRepository->delete($band);
        return $this->json('', 204);
    }
}
