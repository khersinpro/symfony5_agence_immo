<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }
    /**
     * @Route("/biens", name="property.index")
     */
    public function index(): Response
    {

        // $property = new Property();
        // $property->setTitle('Mon premier bien')
        //     ->setDescription('Ce bien est vraiment trés jolie.')
        //     ->setSurface(300)
        //     ->setRooms(12)
        //     ->setBedrooms(5)
        //     ->setFloor(2)
        //     ->setPrice(150000)
        //     ->setHeat(1)
        //     ->setCity('Marseille')
        //     ->setAddress('ceci est une adress')
        //     ->setPostalCode('code postal');
        // $propertyRepository->add($property, true);

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id, Property $property): Response
    {
        if ($slug !== $property->getSlug()) {
            return $this->redirectToRoute('property.show', [
                'slug' => $property->getSlug(), 
                'id' => $id
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
