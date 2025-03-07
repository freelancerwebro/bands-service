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

/**
 * @OA\Tag(name="Bands")
 */
class BandController extends AbstractController
{
    public function __construct(
        private readonly BandRepository $bandRepository,
    ) {
    }

    /**
     * List all bands.
     *
     * @OA\Get(
     *     path="/band",
     *     summary="List all bands",
     *
     *     @OA\Response(response=200, description="List of bands")
     * )
     */
    #[Route('/band', name: 'app_band_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->bandRepository->findAll()
        );
    }

    /**
     * Retrieve a single band by ID.
     *
     * @OA\Get(
     *     path="/band/{id}",
     *     summary="Retrieve a single band",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer"),
     *         description="Band ID"
     *     ),
     *
     *     @OA\Response(response=200, description="Band details"),
     *     @OA\Response(response=404, description="Band not found")
     * )
     */
    #[Route('/band/{id}', name: 'app_band_show_one', methods: ['GET'])]
    public function show(Band $band): JsonResponse
    {
        return $this->json($band);
    }

    /**
     * Add a new band.
     *
     * @OA\Post(
     *     path="/band",
     *     summary="Add a new band",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name"},
     *
     *             @OA\Property(property="name", type="string", description="Band name"),
     *             @OA\Property(property="genre", type="string", description="Music genre")
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Band created"),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    #[Route('/band', name: 'app_band_create', methods: ['POST'])]
    public function create(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
    ): JsonResponse {
        $band = $serializer->deserialize(
            $request->getContent(),
            Band::class,
            'json'
        );

        $errors = $validator->validate($band, null, ['create']);
        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $this->bandRepository->save($band);

        return $this->json($band, 201);
    }

    /**
     * Update an existing band.
     *
     * @OA\Put(
     *     path="/band/{id}",
     *     summary="Update an existing band",
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="genre", type="string")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Band updated"),
     *     @OA\Response(response=404, description="Band not found")
     * )
     */
    #[Route('/band/{id}', name: 'app_band_update', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
    ): JsonResponse {
        $band = $this->bandRepository->find($id);
        if (!$band) {
            return $this->json(['error' => 'Band not found'], 404);
        }

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

        $this->bandRepository->flush();

        return $this->json($band);
    }

    /**
     * Delete a band.
     *
     * @OA\Delete(
     *     path="/band/{id}",
     *     summary="Delete a band",
     *
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response=204, description="Band deleted"),
     *     @OA\Response(response=404, description="Band not found")
     * )
     */
    #[Route('/band/{id}', name: 'app_band_delete', methods: ['DELETE'])]
    public function delete(Band $band): JsonResponse
    {
        $this->bandRepository->delete($band);

        return $this->json('', 204);
    }
}
