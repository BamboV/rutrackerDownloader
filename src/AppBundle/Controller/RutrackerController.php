<?php

namespace AppBundle\Controller;

use BamboV\RutrackerAPI\Entities\Options\SearchOptions;
use BamboV\RutrackerAPI\Entities\Options\SortEntity;
use Core\Rutracker\Exceptions\RutrackerSearchOptionsException;
use Core\Rutracker\Services\RutrackerService;
use Core\Transmission\TransmissionDownloadTorrentFileListener;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerController extends Controller
{

    /**
     * @Route("/rutracker", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('rutracker/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("api/v1/rutracker/forums")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function forumsAction(Request $request)
    {
        return $this->json($this->createRutrackerService($request)->getForums($request->get('reload') == "true"));
    }

    /**
     * @Route("api/v1/rutracker/search")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @throws RutrackerSearchOptionsException
     */
    public function searchAction(Request $request)
    {
        if($searchPhrase = $request->get('phrase')) {
            $searchOptions = new SearchOptions($searchPhrase);
        } else {
            throw new RutrackerSearchOptionsException('phrase');
        }

        $searchOptions->setOnlyOpen($request->get('oop', true) != "false");

        if($forumId = $request->get('forum_id')) {
            $searchOptions->setForumId($forumId);
        }

        if($userName = $request->get('user_name')) {
            $searchOptions->setUserName($userName);
        }

        $searchOptions->setSort(new SortEntity(
            $request->get('sort[field]', 'seeds'),
            $request->get('sort[direction]', 'DESC')
        ));

        $rutrackerService = $this->createRutrackerService($request);
        $result = $rutrackerService->search($searchOptions);

        if($request->get('download_first') == true) {
            $rutrackerService->downloadTorrentFile($result[0]->getId());
        }

        return $this->json($result);
    }

    /**
     * @Route("api/v1/rutracker/download")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @throws RutrackerSearchOptionsException
     */
    public function downloadAction(Request $request){
        if($id = $request->get('id')) {
            $this->createRutrackerService($request)->downloadTorrentFile($id);
        } else {
            throw new RutrackerSearchOptionsException('id');
        }
        return $this->json(null); //TODO: 204
    }

    /**
     * @return RutrackerService
     */
    private function createRutrackerService(Request $request)
    {
        return $this->get('rutracker');
    }
}
