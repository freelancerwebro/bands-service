<?php

namespace App\Controller;

use App\Service\ParserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ImportController extends AbstractController
{
    #[Route('/import', name: 'app_import', methods: ['POST'])]
    public function index(
        Request $request,
        ParserServiceInterface $parserService
    ): JsonResponse {
        $filename = $request->files->get('file')->getPathName();

        $parserService->parse($filename);

        return $this->json([
            'message' => 'Excel import was successfully executed!',
        ]);
    }
}
