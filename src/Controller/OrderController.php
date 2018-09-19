<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        return View::create()->setData(['form' => $form->createView()]);
    }

    /**
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(
            OrderType::class,
            null,
            [
                'action' => $this->generateUrl('app_api_order_post'),
            ]
        );
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException('Request does not contain form');
        }

        if ($form->isValid()) {
            $order = $form->getData();
            $doctrine = $this->getDoctrine();
            $doctrine->getManager()->persist($order);
            $doctrine->getManager()->flush();

            return View::createRouteRedirect(
                'app_api_order_get',
                array('id' => $order->getId()),
                Response::HTTP_CREATED
            );
        }

        return View::create()->setData(['form' => $form->createView()]);
    }

    public function getAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $order = $manager->find(Order::class, $id);
        if (null === $order) {
            throw new NotFoundHttpException("Order#$id not found");
        }

        return View::create()->setData(['data' => $order]);
    }
}
