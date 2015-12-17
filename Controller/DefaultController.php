<?php

namespace Valonde\EgleBundle\Controller;

use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

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
        $brochuresDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads';
        $file = $file->move($brochuresDir, $fileName);

        $url = "https://api.imgur.com/3/image.json";
        $client_id = $this->container->getParameter('imgur_id');
        $image = file_get_contents($brochuresDir . "/" . $fileName);

        $client = new Client();
        $apiRequest = $client->request('POST', 'https://api.imgur.com/3/image.json', [
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
