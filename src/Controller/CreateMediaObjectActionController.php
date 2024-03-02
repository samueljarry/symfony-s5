<?php
namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateMediaObjectActionController extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $em): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();

        try {
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $this->getParameter('kernel.project_dir').'/public/uploads',
                $newFilename
            );
        } catch (FileException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $mediaObject->file = $uploadedFile;
        $mediaObject->filePath = $newFilename;

        $em->persist($mediaObject);
        $em->flush();

        return $mediaObject;
    }
}