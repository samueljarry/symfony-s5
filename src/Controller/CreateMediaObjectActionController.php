<?php
namespace App\Controller;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Filesystem\Filesystem;

#[AsController]
final class CreateMediaObjectActionController extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $em, ParameterBagInterface $params): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $projectDir = $params->get('base_url');

        try {
            $filesystem = new Filesystem();
            $newFilename = uniqid().'.'.$uploadedFile->guessExtension();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$newFilename;
            $filesystem->copy($uploadedFile, $destination);
        } catch (FileException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $mediaObject->file = $uploadedFile;
        $mediaObject->filePath = $projectDir.'public/uploads/'.$newFilename;

        $em->persist($mediaObject);
        $em->flush();

        return $mediaObject;
    }
}
