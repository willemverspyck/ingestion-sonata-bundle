<?php

declare(strict_types=1);

namespace Spyck\IngestionSonataBundle\Controller;

use Exception;
use Spyck\IngestionBundle\Entity\Job;
use Spyck\IngestionBundle\Service\JobService;
use Spyck\IngestionBundle\Utility\DataUtility;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[AsController]
final class JobController extends AbstractController
{
    /**
     * @throws AccessDeniedException
     * @throws Exception
     */
    public function messageAction(JobService $jobService): Response
    {
        $this->admin->checkAccess('list');

        $job = $this->admin->getSubject();

        DataUtility::assert($job instanceof Job, $this->createNotFoundException('Job not found'));

        $jobService->executeJobAsMessage($job);

        $this->addFlash('sonata_flash_success', sprintf('Job message for "%s".', $job));

        return $this->redirectToList();
    }
}
