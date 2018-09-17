<?php

namespace App\Controller;

use App\Form\OrderType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @TODO: description
 */
class OrderController extends FOSRestController
{
    /**
     * @return View
     */
    public function newAction()
    {
        $form = $this->createForm(
            OrderType::class,
            null,
            [
                'action' => $this->generateUrl('app_api_order_post'),
            ]
        );

        return View::create()
            ->setData(array('form' => $form->createView()));
    }

    /**
     * @return View
     */
    public function postAction()
    {
//        $form = $this->createFormBuilder()
//            ->setAction($this->generateUrl(''))
//            ->create(OrderType::class)
//            ->getForm();
//
//        return View::create()
//            ->setData(array('form' => $form->createView()));
    }
}
