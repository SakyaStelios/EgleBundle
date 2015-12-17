<?php

namespace Valonde\EgleBundle\Controller;

use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="valonde_egle_homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('ValondeEgleBundle:Default:index.html.twig');
    }

    /**
     * @Route("/post-to-imgur", name="valonde_egle_post_imgur")
     * @Method("POST")
     */
    public function postToImgurAction(Request $request)
    {

        $file = $request->files->get('file');
        $fileName = md5(uniqid());
        $uploadDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
        $file = $file->move($uploadDir, $fileName);

        $url = "https://api.imgur.com/3/image.json";
        $client_id = $this->container->getParameter('valondeegle.config.imgur_id');
        $image = file_get_contents($uploadDir . "/" . $fileName);

        $client = new Client();
        $apiRequest = $client->request('POST', $url, [
                'headers' => ['Authorization' => 'Client-ID ' . $client_id],
                'form_params' => ['image' => base64_encode($image)],
                'timeout' => 60
        ]);
        
        $body = $apiRequest->getBody();
        $stringBody = (string) $body;
        $imageUploaded = json_decode($stringBody);

        return $this->render('ValondeEgleBundle:Default:index.html.twig', array('imageUploaded' => $imageUploaded));
    }
}
