<?php

namespace App\Controller;

use App\Calculator\OperationCalculator;
use App\DTO\CalculationQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculationController extends AbstractController
{
    public function __construct(private OperationCalculator $calculator, private ValidatorInterface $validator, private SerializerInterface $serializer)
    {
    }

    #[Route(path: '/calculate', name: 'calculate', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $query = $this->serializer->deserialize($request->getContent(), CalculationQuery::class, 'json');

        $errors = $this->validator->validate($query);

        if ($errors->count()) {
            return $this->json(['error' => (string) $errors], 400);
        }

        return $this->json(['result' => $this->calculator->calculate($query->operation)]);
    }
}
