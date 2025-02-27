<?php

namespace App\Controller;

use App\Service\ParserServiceInterface;
use App\Validator\ExcelFileValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @OA\Tag(name="Import")
 */
class ImportController extends AbstractController
{
    /**
     * Import bands from an Excel/CSV file.
     *
     * @OA\Post(
     *     path="/import",
     *     summary="Import bands from an Excel/CSV file",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="file", type="string", format="binary", description="The Excel or CSV file")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="File processed successfully"),
     *     @OA\Response(response=400, description="Invalid file format")
     * )
     */
    #[Route('/import', name: 'app_import', methods: ['POST'])]
    public function index(
        Request $request,
        ParserServiceInterface $parserService,
        ExcelFileValidator $excelFileValidator,
    ): JsonResponse {
        $file = $request->files->get('file');

        if (!$file instanceof UploadedFile) {
            return $this->json(['error' => 'No file uploaded'], Response::HTTP_BAD_REQUEST);
        }

        $validationErrors = $excelFileValidator->validate($file);

        if (!empty($validationErrors)) {
            return $this->json($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        try {
            $filename = $file->getPathname();
            $parserService->parse($filename);
        } catch (FileException $e) {
            return $this->json(['error' => 'File processing failed: '.$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'message' => 'Excel import was successfully executed!',
        ]);
    }
}
