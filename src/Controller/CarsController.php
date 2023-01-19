<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\CarRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\TwigExtra\InkyConfig;

class CarsController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarRepository $repository): Response
    {
        $car = $repository->findAll();
        return $this->render('cars/index.html.twig', [
            'cars'=>$car
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('cars/contact.html.twig', [

        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/us', name: 'app_us',methods:['POST'])]
    public function us(Request $request): Response
    {

        $name = $request->get('name');
        $email = $request->get('email');
        $subject = $request->get('subject');
        $message = $request->get('message');


        $transport = Transport::fromDsn('smtp://naji270297@gmail.com:gawfuaqrfxvmyshe@smtp.gmail.com:587');
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from(new Address($email,$name))
            ->to('naji270297@gmail.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
             ->html('<p>Message: '.$message.'.</p> <br> <p>Email: '.$email.'</p> ')
        ;

        $mailer->send($email);



        $this->addFlash('success','We will replay soon dear client');

        return $this->redirectToRoute('app_contact');
    }

    #[Route('/offers', name: 'app_offers')]
    public function offers(CarRepository $repository): Response
    {
        $car = $repository->findAll();
        return $this->render('cars/offers.html.twig', [
            'cars' => $car
        ]);
    }

    #[Route('/booking/{id}', name: 'app_booking',methods: ['GET','POST'])]
    public function booking(CarRepository $repository,$id): Response
    {
        $car = $repository->find($id);
        return $this->render('cars/booking.html.twig',[
            'cars' =>$car
        ]);
    }

    #[Route('/check_out/{id}', name: 'app_check_out',methods: ['POST','GET'])]
    public function check_out(Request $request,CarRepository $repository ,OrderRepository $orderRepository,$id): Response
    {


        $car = $repository->find($id);
        $order = new Order();
        $price = $car->getPrice();

        $location=$request->request->get('location');
        $pick=$request->request->get('pick');
        $return=$request->request->get('return');
        $amount=$request->request->get('amount');
        $order->setUser($this->getUser());
        $order->setCar($car);
        $order->setPickUpDataTime($pick);
        $order->setTimeRental($return);
        $order->setPickUpLocation($location);
        $order->setAmount($amount);
        $order->setPrice($price * $amount);
        $orderRepository->save($order,true);

//        dd($order);



//        dd($order);

        return $this->render('cars/check_out.html.twig',[
            'orders' =>$order
        ]);
    }




}
