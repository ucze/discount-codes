<?php

namespace App\Controller;

use App\Form\CodeType;
use App\Util\CodesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CodesController
 * @package App\Controller
 */
class CodesController extends AbstractController
{
    /**
     * @var CodesInterface
     */
    private $codesService;

    /**
     * CodesController constructor.
     * @param CodesInterface $codes
     */
    public function __construct(CodesInterface $codes)
    {
        $this->codesService = $codes;
    }

    /**
     * Generate method, displays form, generates discount codes and exposes file as attachment
     * @param Request $request
     * @return Response
     */
    public function generate(Request $request)
    {
        $form = $this->createForm(CodeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $codes = $this->codesService->generate($data['numberOfCodes'], $data['lengthOfCodes']);
            if (empty($codes)) {
                $error = new FormError("Can't generate so many codes, reduce amount and try again");
                $form->get('numberOfCodes')->addError($error);
            } else {
                $response = new Response();
                $response->headers->set('Content-Type', 'mime/type');
                $response->headers->set('Content-Disposition', 'attachment;filename=codes.txt');
                $response->setContent(implode(", ", $codes));
                return $response;
            }
        }

        return $this->render('codes/generate.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}