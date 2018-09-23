<?php

namespace Puzzle\App\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Puzzle\ConnectBundle\Service\PuzzleApiObjectManager;
use GuzzleHttp\Exception\BadResponseException;
use Puzzle\ConnectBundle\Event\ApiResponseEvent;
use Puzzle\ConnectBundle\Service\ErrorFactory;
use Puzzle\ConnectBundle\ApiEvents;

/**
 *
 * @author AGNES Gnagne Cedric <cecenho55@gmail.com>
 *
 */
class ContactController extends Controller
{
    /**
     * @var array $fields
     */
    private $fields;
    
    public function __construct() {
        $this->fields = ['firstName', 'lastName', 'email', 'phone', 'company', 'position', 'location'];
    }
    
    /***
     * Create a new contact
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request) {
        if ($request->isMethod('POST') === true) {
            $postData = $request->request->all();
            $postData = PuzzleApiObjectManager::sanitize($postData);
            
            try {
                /** @var Puzzle\ConectBundle\Service\PuzzleAPIClient $apiClient */
                $apiClient = $this->get('puzzle_connect.api_client');
                $contact = $apiClient->push('post', '/contact/contacts', $postData);
                
                if ($request->isXmlHttpRequest() === true) {
                    return new JsonResponse(true);
                }
                
                $this->addFlash('success', $this->get('translator')->trans('message.post', [], 'success'));
                return $this->redirectToRoute('admin_contact_update', array('id' => $contact['id']));
            }catch (BadResponseException $e) {
                /** @var EventDispatcher $dispatcher */
                $dispatcher = $this->get('event_dispatcher');
                $event = $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
                
                if ($request->isXmlHttpRequest() === true) {
                    return $event->getResponse();
                }
                
                return $this->redirectToRoute('app_contact');
            }
        }
        
        return $this->render($this->getParameter('app_contact.templates')['contact']['create']);
    }
}
