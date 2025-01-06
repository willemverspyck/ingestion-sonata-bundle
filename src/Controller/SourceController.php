<?php

declare(strict_types=1);

namespace Spyck\IngestionSonataBundle\Controller;

use Exception;
use Spyck\IngestionBundle\Entity\Source;
use Spyck\IngestionBundle\Service\SourceService;
use Spyck\IngestionBundle\Utility\DataUtility;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[AsController]
final class SourceController extends AbstractController
{
    /**
     * @throws AccessDeniedException
     * @throws Exception
     */
    public function messageAction(SourceService $sourceService): Response
    {
        $this->admin->checkAccess('list');

        $source = $this->admin->getSubject();

        DataUtility::assert($source instanceof Source, $this->createNotFoundException('Source not found'));

        $sourceService->executeSourceAsMessage($source);

        $this->addFlash('sonata_flash_success', sprintf('Source message for "%s".', $source));

        return $this->redirectToList();
    }
}
